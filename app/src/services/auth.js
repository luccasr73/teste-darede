import decode from 'jwt-decode'
import { set, del } from 'idb-keyval'
import { TOKEN_KEY } from '../../env'
import {
  post
} from './request'

async function signIn (email, password) {
  const res = await post('/login', {
    email,
    password
  })
  await set(TOKEN_KEY, res.data.token)
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

async function signOut () {
  await del(TOKEN_KEY)
}

function isSignedIn () {
  const token = localStorage.getItem('token')

  if (!token) {
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
