import api from '@/services/api' // o '../services/api' según tu estructura

export const login = async (email, password) => {
  const response = await api.post('/login', {
    email,
    password,
  })
  return response.data
}

export const register = async (name, email, password) => {
  const response = await api.post('/register', {
    name,
    email,
    password,
  })
  return response.data
}

export const getUser = async () => {
  const response = await api.get('/me')
  return response.data
}
