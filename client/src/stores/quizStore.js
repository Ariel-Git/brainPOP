import { defineStore } from 'pinia';

export const useQuizStore = defineStore('quizStore', {
  state: () => ({
    questions: [],
    userAnswers: [], // Array of user's selected answers
    currentQuestionIndex: 0,
    quizSubject: '',
  }),
  actions: {
    setQuizSubject(quizSubject) {
      this.quizSubject = quizSubject;
    },
    setQuestions(questions) {
      this.questions = questions;
    },
    answerQuestion(index, option) {
      this.userAnswers[index] = option;
    },
    nextQuestion() {
      if (this.currentQuestionIndex < this.questions.length - 1) {
        this.currentQuestionIndex++;
      }
    },
    previousQuestion() {
      if (this.currentQuestionIndex > 0) {
        this.currentQuestionIndex--;
      }
    },
  },
});
