<template>
  <div>
    <!-- Loading spinner when fetching quiz data -->
    <div v-if="loading" class="loader-container">
      <div class="loader">Loading...</div>
    </div>
    <div v-if="error" class="error-container">
      <div class="error">{{ errorMessage }}</div>
    </div>
    <!-- Display feature if supported -->
    <component v-if="supportedFeatures[featureType] && !loading && !error" :data="data" :is="featureType" />

    <!-- Display error message when feature is not supported -->
    <span v-else>{{ featureType }} feature is NOT supported YET</span>
  </div>
</template>

<script>
// FEATURE TYPES
import Quiz from '@/components/screens/features/quiz/Quiz.vue'
import { fetchQuiz } from "@/services/api";
import { useQuizStore } from "@/stores/quizStore";

export default {
  name: 'Feature',
  components: {
    Quiz
  },
  data() {
    return {
      supportedFeatures: {
        quiz: true
      },
      featureType: 'quiz',
      loading: true, // Added loading state
      error: false,
      errorMessage:null
    };
  },
  computed: {
    data() {
      const store = useQuizStore();
      return { 
        name: store.quizSubject,
        questions: JSON.parse(store.questions).length
      };
    }
  },  
  mounted() {
    this.featureType = this.$route.params.type?.toLowerCase() || this.featureType.toLowerCase();
    
    const store = useQuizStore();
    
    // Fetch data asynchronously
    (async () => {
      try {
        const response = await fetchQuiz();
        
        store.setQuizSubject(response.data.title); 
        store.setQuestions(JSON.stringify(response.data.questions)); 
        
        this.loading = false;
      } catch (err) {
        this.errorMessage = "Failed to fetch quiz questions. Please try again later."
        this.loading = false; 
        this.error = true;
      }
    })();
  }
};
</script>

<style lang="scss" scoped>
.feature_container {
  display: flex;
  justify-content: center;
  align-items: center;
  position: relative; 
}

.loader-container {
  position: absolute;
  top: 0;
  left: 0;
  right: 0;
  bottom: 0;
  display: flex;
  justify-content: center;
  align-items: center;
  background: rgba(255, 255, 255, 0.8); 
}

.loader {
  font-size: 1.5em;
  color: #00796b;
  font-weight: bold;
}
</style>
