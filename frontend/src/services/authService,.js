import api from '@/services/api'

export const login = async (email, password) => {
  const response = await api.post('/login', {
    email,
    password,
  })
  return response.data
}

export const register = async (nombre, email, password) => {
  const response = await api.post('/register', {
    nombre,
    email,
    password,
  })
  return response.data
}

export const getUser = async () => {
  const response = await api.get('/me')
  return response.data
}
