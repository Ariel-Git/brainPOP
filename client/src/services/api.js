import axios from 'axios';

const API = axios.create({ baseURL: 'http://localhost:3000/api' });
import { useUserStore } from "@/stores/user";

/* 
    Fetch quiz
*/
export async function fetchQuiz() {
    const userStore = useUserStore();
    const userToken = userStore.getUserToken;
    return await API.get('/quiz',{
        headers: {
          'Authorization': userToken
        }
      });
}
/* 
    Submit answers
*/
export async function submitAnswers(answers) {
    const userStore = useUserStore();
    const userToken = userStore.getUserToken; 
    try {
        return await API.post(
            '/quiz/submit',
            { answers }, 
            {
                headers: {
                    'Authorization': userToken, 
                },
            }
        );
    } catch (error) {
        console.error("Error submitting answers:", error);
        throw error; 
    }
}

/* 
    Login Request
*/
export async function loginRequest(credentials) {
    const {userName:email,password} = credentials;
    return await API.post('/login', {email, password});
}

/* 
    Get user Last quiz Result
*/
export async function getLastResult() {
    const userStore = useUserStore();
    const userToken = userStore.getUserToken; 
    try {
        return await API.get(
            'user/get-last-answers',
            {
                headers: {
                    'Authorization': userToken, 
                },
            }
        );
    } catch (error) {
        console.error("Error getting last submitted answers:", error);
        throw error; 
    }
}