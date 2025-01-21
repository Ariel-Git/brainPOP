<template>
  <Navigator
      :items="[
        { text: quizSubject, to: `/feature/quiz` },
        { text: 'Quiz', to: '' }
      ]"
    />
    <div class="headerSpacer">
    </div>
  <div class="quiz-container">
    <!-- Display sending State -->
    <div v-if="sending">
      <p>Sending answers...</p>
    </div>
    <!-- Display Error State -->
    <div v-else-if="error">
      <p>{{ error }}</p>
    </div>
    <!-- Display Current Question -->
    <div class="quiz-content" v-else-if="currentQuestion">
    <div class="quiz-question" >
      <div class="question-number">
          <span>{{ currentQuestionIndex + 1 }}</span>
        </div>
        <div class="question-text">
          <p>{{ currentQuestion.question }}</p>
        </div>
      </div>
      <div class="quiz-answers">
        <div class="answer-option"
          :class="{ selected: selectedOption === answer.id }"
          v-for="(answer, idx) in currentQuestion.answers"
          :key="answer.id"
          @click="selectedOption = answer.id"
        >
          <input
            type="radio"
            :id="'answer-' + answer.id"
            :value="answer.id"
            v-model="selectedOption"
            :name="'question-' + currentQuestionIndex"
          />
          <span class="answer-label">
            {{ String.fromCharCode(65 + idx) }}
          </span>
          <label :for="'answer-' + answer.id">{{ answer.answer }}</label>
        </div>
      </div>
    </div>
  </div>
  <!-- Navigation Buttons -->
  <footer class="quiz-footer">
    <div class="footer-navigation" v-if="!error">
      <button @click="goBack" class="nav-button button back-button" :disabled="currentQuestionIndex === 0">Back</button>
      <button v-if="!isLastQuestion" @click="goNext" :disabled="!canProceed" class="nav-button button">Next</button>
      <button v-if="isLastQuestion" @click="submitQuiz" :disabled="!canProceed" class="nav-button button">Submit</button>
    </div>
  </footer>
</template>

<script>
import Navigator from '@/components/compositions/navigator/Navigator.vue';
import { computed, ref, onMounted } from "vue";
import { useRouter } from "vue-router";
import { useQuizStore } from "@/stores/quizStore";
import { submitAnswers } from "@/services/api";

export default {
  name: "QuizQuestionsScreen",
  components: { Navigator },
  setup() {
    const router = useRouter();
    const store = useQuizStore();

    const sending = ref(false);
    const error = ref(null);
    const quizSubject = ref(null);

    quizSubject.value = store.quizSubject
    const parsedQuestions = JSON.parse(store.questions);
    const currentQuestion = computed(
      () => parsedQuestions[store.currentQuestionIndex]
    );
    const currentQuestionIndex = computed(() => store.currentQuestionIndex);
    const questions = computed(() => parsedQuestions);

    const selectedOption = computed({
      get: () => store.userAnswers[store.currentQuestionIndex] ?? null,
      set: (value) => store.answerQuestion(store.currentQuestionIndex, value),
    });

    const isLastQuestion = computed(
      () => currentQuestionIndex.value === questions.value.length - 1
    );
    const canProceed = computed(() => selectedOption.value !== null);

    const goNext = () => {
      store.nextQuestion();
    };

    const goBack = () => {
      store.previousQuestion();
    };

    const submitQuiz = async () => {
    // Format answers for the API
    const formattedAnswers = questions.value.map((question, index) => ({
      questionId: question.id,
      selectedAnswer: store.userAnswers[index],
    }));

    try {
      // Send the answers to the backend
      sending.value = true;
      const response = await submitAnswers( JSON.stringify({ answers: formattedAnswers }));
      if (response.status === 200) {
        sending.value = false;
        router.push({ path: "/summary" });
      } else {
        sending.value = false;
        // Handle errors
        alert(`Error: ${response.errorData.message || "Failed to submit the quiz"}`);
      }
    } catch (err) {
      sending.value = false;
      alert("Error: Could not send your answers");
    }
  };

    return {
      sending,
      error,
      quizSubject,
      currentQuestion,
      currentQuestionIndex,
      questions,
      selectedOption,
      isLastQuestion,
      canProceed,
      goNext,
      goBack,
      submitQuiz,
    };
  },
};         
</script>

<style lang="scss">
/* Container */
.quiz-container {
  margin-block: 100px auto;
  display: flex;
  flex-direction: column;
  width: 100%;
  font-family: Arial, sans-serif;
  color: #333;
  
}
  body .navigation {
    position: unset !important;
    width: 100vw !important;
    padding-left: 3em !important;
}
/* Main Content */
.quiz-content {
  flex: 1;
  padding: 20px;
  display: flex;
  flex-direction: column;
  align-items: flex-start;

  .quiz-question {
    display: flex;
    margin-bottom: 20px;
    .question-number {
      font-size: 48px;
      font-weight: bold;
      margin-right: 10px;
    }
    .question-text {
      font-size: 18px;
    }
  }

  .quiz-answers {
    display: flex;
    flex-direction: column;
    gap: 10px;
    width: 100%;
    .answer-option {
      display: flex;
      align-items: center;
      border: 1px solid #ddd;
      padding: 10px;
      border-radius: 5px;
      cursor: pointer;
      transition: background-color 0.3s ease;
      &:hover {
        background-color: #f0f0f0;
      }
      &.selected {
        border: 2px solid #00796b;
        background-color: #e0f2f1;
      }
      input[type="radio"] {
        display: none;
      }
      .answer-label {
        margin-right: 10px;
        font-weight: bold;
        border: 1px black solid;
        border-radius: 100%;
        padding: 0.2em 0.4em;
      }
      label{
        width: 100%;
        height: 100%;
        cursor: pointer;
      }
      p {
        margin: 0;
      }
    }
  }
}

/* Footer */
.quiz-footer {
  position: absolute;
  right: 0;
  bottom: 0;
  padding: 10px;
  text-align: right;
  .footer-navigation {
    
  .button {
    padding: 10px 20px;
    border: none;
    background-color: #00796b;
    border: 2px #00796b solid;
    color: #fff;
    cursor: pointer;
    border-radius: 5px;
    &:disabled {
      visibility: hidden;
      background-color: #ccc;
      cursor: not-allowed;
    }
  }
  .back-button{
    background-color:#ffffff;
    color: #00796b;
  }
}
}

</style>
<!--  -->