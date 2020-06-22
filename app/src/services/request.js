import axios from 'axios'
import {
  API,
  TOKEN_KEY
} from '../../env'

axios.interceptors.request.use(function (config) {
  const token = localStorage.getItem(TOKEN_KEY)

  if (token != null) {
    config.headers.Authorization = `Bearer ${token}`
  }

  return config
},
function (err) {
  return Promise.reject(err)
})

async function post (url, body) {
  return await axios.post(API + url, body)
}
async function get (url, body) {
  return await axios.get(API + url, body)
}

export {
  post,
  get
}
