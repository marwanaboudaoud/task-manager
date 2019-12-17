import gql from "graphql-tag";

export const SIGN_IN = gql`
  query($email: String!, $password: String!) {
    login(email: $email, password: $password) {
      token
      token_type
      expires_in
      user {
        id
        first_name
        last_name
        email
        note {
          id
          text
        }
      }
    }
  }
`;

export const GET_MEETINGS = gql`
  query {
    meetingLists {
      id
      name
    }
  }
`;

export const GET_MEETING_TASKS_TOTAL = gql`
  query($meeting_list_id: Int!) {
    tasksTotal(meeting_list_id: $meeting_list_id)
  }
`;

export const GET_MEETING_TASKS_DONE = gql`
  query($meeting_list_id: Int!) {
    tasksDone(meeting_list_id: $meeting_list_id)
  }
`;

export const GET_MEETING = gql`
  query($id: Int!) {
    meetingList(id: $id) {
      id
      name
      creator {
        id
        first_name
        last_name
        email
      }
      attendees {
        id
        first_name
        last_name
        email
      }
      categories {
        id
        name
        slug
        tasks {
          id
          title
          description
          deadline
          assignee {
            id
            first_name
            last_name
            email
          }
          is_completed
          created_at
          updated_at
        }
      }
    }
  }
`;

export const RETRIEVE_ATTENDEES = gql`
  query($meeting_id: Int!) {
    attendees(meeting_id: $meeting_id) {
      id
      first_name
      last_name
    }
  }
`;

export const SEARCH_USER = gql`
  query($q: String!) {
    searchUser(q: $q) {
      id
      first_name
      last_name
      email
      meetingLists {
        id
      }
    }
  }
`;

export const GET_MY_TASKS = gql`
  query {
    myTasks {
      id
      name
      tasks {
        id
        title
        description
        deadline
        assignee {
          id
          first_name
          last_name
        }
        is_completed
        category {
          id
          name
        }
        created_at
        updated_at
      }
    }
  }
`;

export const GET_USER_NOTE = gql`
  query {
    user {
      id
      note {
        id
        text
      }
    }
  }
`;
