import decode from 'jwt-decode'
import { TOKEN_KEY } from '../../env'
import {
  post
} from './request'

async function signIn (email, password) {
  const res = await post('/login', {
    email,
    password
  })
  localStorage.setItem(TOKEN_KEY, res.data.token)
  return res
}

async function signUp (email, password, confirmPassword) {
  const res = await post('/cadastrar', {
    email,
    password,
    confirm_password: confirmPassword
  })
  return res
}

function signOut () {
  localStorage.removeItem(TOKEN_KEY)
}

function isSignedIn () {
  const token = localStorage.getItem(TOKEN_KEY)
  if (!token || token === null) {
    return false
  }
  try {
    const {
      exp: expiration
    } = decode(token)
    const isExpired = !!expiration && Date.now() > expiration * 1000

    if (isExpired) {
      return false
    }
    return true
  } catch (_) {
    return false
  }
}

export {
  isSignedIn,
  signOut,
  signIn,
  signUp
}
