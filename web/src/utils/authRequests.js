import axios from 'axios'

const REACT_APP_API_LARAVEL =
  process.env.NODE_ENV === 'development'
    ? 'http://127.0.0.1:8000/api'
    : 'https://taskmanager.fortagroep.nl/project/api'

export const SIGN_IN_REQUEST = ({ email, password }) =>
  axios.post(
    `${REACT_APP_API_LARAVEL}/connect/login?email=${email.toString()}&password=${password.toString()}`
  )

export const REGISTER_USER_REQUEST = ({
  email,
  password,
  password_confirmation,
  first_name,
  last_name
}) =>
  axios.post(
    `${REACT_APP_API_LARAVEL}/connect/register?email=${email.toString()}&password=${password.toString()}&password_confirmation=${password_confirmation.toString()}&first_name=${first_name.toString()}&last_name=${last_name.toString()}`
  )

// /api/connect/login
// /api/connect/register
// /api/connect/forgot // sends forgot password mail
// /api/connect/reset // resets the password
// /api/connect/logout
