import { defineStore } from 'pinia';

export const useQuizStore = defineStore('quizStore', {
  state: () => ({
    questions: [],
    userAnswers: [], // Array of user's selected answers
    currentQuestionIndex: 0,
    quizSubject: '',
    quizResult: null,
  }),
  getters: {
    getQuizResult: state => {
      let quizResult = window.localStorage.getItem('quizResult')
      return quizResult || state.quizResult
    },
    getQuizSubject: state => {
      let quizSubject = window.localStorage.getItem('quizSubject')
      return quizSubject || state.quizSubject
    },
    getQuestions: state => {
      let questions = window.localStorage.getItem('questions')
      return questions || state.questions
    }
  },
  actions: {
    setQuizSubject(quizSubject) {
      this.quizSubject = quizSubject;
      window.localStorage.setItem('quizSubject', this.quizSubject)
    },
    setQuestions(questions) {
      this.questions = questions;
      window.localStorage.setItem('questions', this.questions)
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
    setQuizResult(quizResult) {
      this.quizSubject = quizResult;
      window.localStorage.setItem('quizResult', this.quizSubject)
    },
  },
});
