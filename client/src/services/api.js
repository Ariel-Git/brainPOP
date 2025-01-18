import axios from 'axios';

const API = axios.create({ baseURL: 'http://localhost:3000/api' });

export async function fetchQuiz() {
    return await API.get('/quiz');
}

export async function submitAnswers(answers) {
    return await API.post('/quiz/submit', { answers });
}