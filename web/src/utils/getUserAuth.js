export const persistUserData = user => {
  localStorage.setItem("AUTH_USER", JSON.stringify(user));
  window.location.reload();
};

export const expired_token = "expired_token";

export const expired_token_backend_message = "GraphQL error: Token has expired";

export const removeUserData = () => localStorage.removeItem("AUTH_USER");
const userData = localStorage.getItem("AUTH_USER") || "";
export const token = userData ? JSON.parse(userData).token.value : "";
export const user = userData ? JSON.parse(userData).user : {};
export const user_id = userData ? JSON.parse(userData).user.id : 0;
export const user_email = userData ? JSON.parse(userData).user.email : 0;
export const userLoggedIn = token ? true : false;

export const logUserOut = () => {
  localStorage.removeItem("AUTH_USER");
  window.location.reload();
};
