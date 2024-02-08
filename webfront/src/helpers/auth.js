import axios from 'axios'

axios.defaults.baseURL = 'http://127.0.0.1:8000/api/'
const AUTH_TOKEN_KEY = 'token'

// save the token in local storage and we created an authorization header so that future request will be varified 
export function setAuthToken(token) {
    axios.defaults.headers.common['Authorization'] = `Bearer ${token}`
    localStorage.setItem(AUTH_TOKEN_KEY, token)
}

// get the token from storage when i need it 
export function getAuthToken() {
    return localStorage.getItem(AUTH_TOKEN_KEY)
}
// clear the header and remove the token from storage 
export function clearAuthToken() {
    axios.defaults.headers.common['Authorization'] = ''
    localStorage.removeItem(AUTH_TOKEN_KEY)
}


// // use the token to verify if user is loged in 
// export function isLoggedIn() {
//     let authToken = getAuthToken()
//     return !!authToken && !isTokenExpired(authToken)
// }

// // get the info from the token 
// export function getUserInfo() {
//     if (isLoggedIn()) {
//         return decode(getAuthToken())
//     }
// }

// knowing the exp in the token  in seconds 
// export function getTokenExpirationDate(encodedToken) {
//     let token = decode(encodedToken)
//     if (!token.exp) {
//         return null
//     }
//     let date = new Date(0)
//     date.setUTCSeconds(token.exp)
//     return date
// }

// // check if the token has expired or not 
// export function isTokenExpired(token) {
//     let expirationDate = getTokenExpirationDate(token)
//     return expirationDate < new Date()
// }

// export function isAdmin() {
//     let userData = getUserInfo()
//     if (userData.data.user_role === true) {
//         return true
//     }
// }

// export function isActive() {
//     let userData = getUserInfo()
//     if (userData.data.is_active === true) {
//         return true
//     }

// }