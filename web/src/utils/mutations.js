import gql from "graphql-tag";

export const ADD_MEETING = gql`
  mutation($name: String!) {
    createMeetingList(name: $name) {
      id
      name
    }
  }
`;

export const EDIT_MEETING = gql`
  mutation($name: String!, $id: Int!) {
    editMeetingList(name: $name, id: $id) {
      id
      name
    }
  }
`;

export const CREATE_TASK = gql`
  mutation(
    $title: String!
    $description: String
    $deadline: String
    $category_id: Int!
    $meeting_list_id: Int!
    $email: String
  ) {
    createTask(
      title: $title
      description: $description
      deadline: $deadline
      category_id: $category_id
      meeting_list_id: $meeting_list_id
      email: $email
    ) {
      id
      title
    }
  }
`;

export const EDIT_TASK = gql`
  mutation(
    $id: Int!
    $title: String
    $description: String
    $deadline: String
    $category_id: Int
    $email: String
    $meeting_list_id: Int!
    $is_completed: Boolean
  ) {
    editTask(
      id: $id
      title: $title
      description: $description
      deadline: $deadline
      category_id: $category_id
      meeting_list_id: $meeting_list_id
      email: $email
      is_completed: $is_completed
    ) {
      id
    }
  }
`;

export const DELETE_TASK = gql`
  mutation($id: Int!) {
    deleteTask(id: $id) {
      id
    }
  }
`;

export const REGISTER_USER = gql`
  mutation($email: String!, $password: String!, $password_repeat: String!) {
    register(
      email: $email
      password: $password
      password_repeat: $password_repeat
    ) {
      first_name
      last_name
    }
  }
`;

export const ADD_ATTENDEE_TO_MEETING = gql`
  mutation($email: String, $meeting_id: Int) {
    addAttendee(email: $email, meeting_id: $meeting_id) {
      id
      name
      attendees {
        id
        first_name
        last_name
        email
      }
    }
  }
`;

export const REMOVE_ATTENDEE_FROM_MEETING = gql`
  mutation($user_id: Int!, $meeting_id: Int!) {
    removeAttendee(user_id: $user_id, meeting_id: $meeting_id) {
      id
      name
      attendees {
        id
        first_name
        last_name
        email
      }
    }
  }
`;

export const ADD_CATEGORY_TO_MEETING = gql`
  mutation($name: String, $meeting_list_id: Int, $order: Int) {
    createCategory(name: $name, meeting_list_id: $meeting_list_id, order: $order) {
      id
      name
      order
      slug
    }
  }
`;

export const EDIT_NOTE = gql`
  mutation($text: String, $user_id: Int) {
    editNote(text: $text, user_id: $user_id) {
      id
      text
    }
  }
`;
