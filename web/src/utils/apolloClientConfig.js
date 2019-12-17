import { ApolloClient, InMemoryCache } from 'apollo-boost'
import { setContext } from 'apollo-link-context'
import { createHttpLink } from 'apollo-link-http'
import { token } from './getUserAuth'

const REACT_APP_API_GQL =
  process.env.NODE_ENV === 'development'
    ? 'http://127.0.0.1:8080/graphql'
    : 'https://taskmanager.fortagroep.nl/project/graphql'

export const client = () => {
  const httpLink = createHttpLink({
    uri: REACT_APP_API_GQL
  })

  const authLink = setContext((_, { headers }) => {
    // get the authentication token from local storage if it exists
    // return the headers to the context so httpLink can read them
    return {
      headers: {
        ...headers,
        authorization: token ? `Bearer ${token}` : ''
      }
    }
  })

  return new ApolloClient({
    link: authLink.concat(httpLink),
    cache: new InMemoryCache({
      dataIdFromObject: object => object.id
    }),
    clientState: {
      defaults: {},
      resolvers: {},
      typeDefs: ``
    }
  })
}
