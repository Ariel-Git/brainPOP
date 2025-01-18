
<template>
  <Navigator
    :items="[ { text: quizSubject, to: `/feature/quiz` }, { text: 'Quiz', to: '' } ]"
  />
  <div class="headerSpacer">
  </div>
  <header>
    <h2>Scored {{ correct }}/{{ total }}</h2>
  </header>

  <div class="quiz-container">
    <!-- Display Questions and Answers -->
    <div
      class="quiz-content"
      v-for="(question, questionIndex) in questions"
      :key="question.id"
    >
      <div class="quiz-question">
        <div class="question-number">
          <span>{{ question.id }}</span>
        </div>
        <div class="question-text">
          <p>{{ question.question }}</p>
        </div>
      </div>

      <div class="quiz-answers">
        <!-- Loop through the answers -->
        <div
          class="answer-option"
          v-for="(answer, answerIndex) in question.answers"
          :key="answer.id"
          :class="{
            correct:
              answer.id === getAnswerDetails(question.id).selectedAnswer &&
              getAnswerDetails(question.id).isCorrect === 1,
            incorrect:
              answer.id === getAnswerDetails(question.id).selectedAnswer &&
              getAnswerDetails(question.id).isCorrect === 0,
          }"
        >
          <span class="answer-label">{{ String.fromCharCode(65 + answerIndex) }}</span>
          <label>
            {{ answer.answer }}
            
          </label>
          <div class="xv" v-if="answer.id === getAnswerDetails(question.id).selectedAnswer">
              {{ getAnswerDetails(question.id).isCorrect ? '✓' : '✗' }}
          </div>
        </div>
      </div>
    </div>
  </div>
</template>    
<script>
import Navigator from "@/components/compositions/navigator/Navigator.vue";
import { useQuizStore } from "@/stores/quizStore";
import { ref } from "vue";

export default {
  name: "SummaryScreen",
  props: {
    correct: { type: Number, required: true },
    total: { type: Number, required: true },
    answers: { type: Array, required: true }, // Expected structure from server response
  },
  components: { Navigator },
  setup(props) {
    const store = useQuizStore();
    const loading = ref(true);
    const error = ref(null);
    const questions = ref(store.questions);

    // Helper function to find the answer details for a specific question
    const getAnswerDetails = (questionId) => {
      return (
        props.answers.find((answer) => answer.questionId === questionId) || {
          selectedAnswer: null,
          isCorrect: null,
        }
      );
    };

    return {
      quizSubject: store.quizSubject,
      questions,
      loading,
      error,
      getAnswerDetails,
    };
  },
};
</script>


<style lang="scss">
template>.navigation{
  position:unset;
}
.headerSpacer {
  background: #f3f3f3;
  width: 100%;
  padding: 2em;
  display: flex;
  gap: 0.5rem;
}
/* Container */
.quiz-container {
    margin-block: 100px auto;
    display: flex;
    flex-direction: column;
    /* width: 100%; */
    font-family: Arial, sans-serif;
    color: #333;
    flex-wrap: wrap;
    align-content: center;
}
header {
  background: #eef7f7;
  width: 100%;
  padding: 12px;
  text-align: center;
  padding: 1em;
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
      div.xv {
          right: -40px;
          font-size: 0.8em;
          position: relative;
          border: 1px transparent solid;
          border-radius: 100%;
          padding: 0 0.3em;
          color: #ffffff;
      }
    }
    .answer-option.correct{
      background-color: #f0fff0;
      border-color: #3da461;
      .answer-label {
        border-color: #198786;
        background-color: #ccf5f5;
      }
      .xv{
        background-color: #007906a1;
      }
    }
    .answer-option.incorrect{
      background-color: #fdf7f7;
      border-color: #ec407a;
      .answer-label {
        border-color: #198786;
        background-color: #ccf5f5;
      }
      .xv{
        background-color: #d80a0ae7;
      }
    }
  }
}

</style>
<!--  -->