import React from "react";
import { Card, Form, Row, Col, Container } from "react-bootstrap";
import styles from "./styles.module.scss";
import { Link } from "react-router-dom";
import { SIGN_IN_REQUEST } from "../../utils/authRequests";
import {
  token as persistedToken,
  persistUserData,
  expired_token
} from "../../utils/getUserAuth";
import ProgessSmall from "../../components/Progress/ProgressSmall.tsx";

class LoginPage extends React.Component {
  state = {
    variables: {
      username: "",
      password: ""
    },
    loading: false
  };

  componentDidMount() {
    const { openAlert, location } = this.props;
    location.search === `?${expired_token}` &&
      openAlert({
        alertVisible: true,
        alertTitle: "Please sign in",
        alertMessage: "Your login has expired"
      });

    this._redirectToApp();
  }

  componentDidUpdate() {
    this._redirectToApp();
  }

  _redirectToApp() {
    const { history } = this.props;
    persistedToken && history.push("/");
  }

  _onChange = (name, e) => {
    this.setState({
      variables: {
        ...this.state.variables,
        [name]: e.target.value
      }
    });
  };

  _onComplete = ({ access_token, expires_in, token_type, user }) => {
    persistUserData({
      token: {
        value: access_token,
        expires_in,
        token_type
      },
      user: {
        id: user.id,
        first_name: user.first_name,
        last_name: user.last_name,
        email: user.email
      }
    });
  };

  render() {
    const { openAlert } = this.props;
    const { variables, loading } = this.state;
    return (
      <div>
        <Card>
          <div className={styles.header}>
            <Card.Body>
              <Card.Title className={styles.title}>
                <span className={styles.forta}> FORTA </span> TASKMANAGER
              </Card.Title>
            </Card.Body>
          </div>
        </Card>

        <Form
          onSubmit={async e => {
            e.preventDefault();
            e.stopPropagation();

            this.setState({ loading: true });

            SIGN_IN_REQUEST(variables)
              .then(response => {
                this._onComplete(response.data);
                this.setState({ loading: false });
              })
              .catch(error => {
                this.setState({ loading: false });

                openAlert({
                  alertVisible: true,
                  alertMessage: error.message
                });
              });
          }}
        >
          <div className={styles.login}>
            <Container>
              <Row>
                <Col md={{ span: 4, offset: 4 }}>
                  <label className={styles.formLabel}>Inloggen</label>
                </Col>
              </Row>
              <Row>
                <Col md={{ span: 5, offset: 4 }}>
                  <input
                    className={styles.input}
                    type="text"
                    name="email"
                    value={variables.email}
                    onChange={e => this._onChange("email", e)}
                    placeholder="Gebruikersnaam"
                    disabled={loading}
                  />
                </Col>
              </Row>
              <Row>
                <Col md={{ span: 5, offset: 4 }}>
                  <input
                    className={styles.input}
                    type="password"
                    name="password"
                    value={variables.password}
                    onChange={e => this._onChange("password", e)}
                    placeholder="Wachtwoord"
                    disabled={loading}
                  />
                  <a href="/" className={styles.forgotten}>
                    Vergeten ?
                  </a>
                </Col>
              </Row>
              <Row>
                <Col md={{ span: 5, offset: 4 }}>
                  <div className={styles.formButtons}>
                    <Link to="/dashboard" className={styles.link}>
                      <button
                        type="submit"
                        className={styles.firstBtn}
                        disabled={loading}
                      >
                        Inloggen
                      </button>
                    </Link>
                    <Link to="/registreren" className={styles.link}>
                      <button className={styles.secondBtn}>
                        Account activeren
                      </button>
                    </Link>
                  </div>
                </Col>
              </Row>
            </Container>
            {loading && (
              <div className={styles.progesscontainer}>
                {<ProgessSmall visible />}
              </div>
            )}
          </div>
        </Form>
      </div>
    );
  }
}

export default LoginPage;

// import React, { Component } from "react";
// import { Card, Form, Row, Col, Container } from "react-bootstrap";
// import styles from "./styles.module.scss";
// import { Link } from "react-router-dom";

// class LoginPage extends Component {
//   constructor() {
//     super();
//     this.state = {
//       username: "",
//       password: "",
//       error: "",
//     };

//     this.handlePassChange = this.handlePassChange.bind(this);
//     this.handleUserChange = this.handleUserChange.bind(this);
//     this.handleSubmit = this.handleSubmit.bind(this);
//     this.dismissError = this.dismissError.bind(this);
//   }

//   dismissError() {
//     this.setState({ error: "" });
//   }

//   handleSubmit(e) {
//     e.preventDefault();

//     if (!this.state.username) {
//       return this.setState({ error: "Username is required" });
//     }

//     if (!this.state.password) {
//       return this.setState({ error: "Password is required" });
//     }

//     return this.setState({ error: "" });
//   }

//   handleUserChange(e) {
//     this.setState({
//       username: e.target.value,
//     });
//   }

//   handlePassChange(e) {
//     this.setState({
//       password: e.target.value,
//     });
//   }

//   render() {
//     return (
//       <div>
//         <Card>
//           <div className={styles.header}>
//             <Card.Body>
//               <Card.Title className={styles.title}>
//                 <span className={styles.forta}> FORTA </span> TASKMANAGER
//               </Card.Title>
//               <Card.Text></Card.Text>
//             </Card.Body>
//           </div>
//         </Card>

//         <Form onSubmit={this.handleSubmit}>
//           <div className={styles.login}>
//             <Container>
//               <Row>
//                 <Col md={{ span: 4, offset: 4 }}>
//                   <label className={styles.formLabel}>Inloggen</label>
//                 </Col>
//               </Row>
//               <Row>
//                 <Col md={{ span: 4, offset: 4 }}>
//                   <input
//                     className={styles.input}
//                     type="text"
//                     data-test="username"
//                     value={this.state.username}
//                     onChange={this.handleUserChange}
//                     placeholder="Gebruikersnaam"
//                   />
//                 </Col>
//               </Row>
//               <Row>
//                 <Col md={{ span: 4, offset: 4 }}>
//                   <input
//                     className={styles.input}
//                     type="password"
//                     data-test="password"
//                     value={this.state.password}
//                     onChange={this.handlePassChange}
//                     placeholder="Wachtwoord"
//                   />
//                   <a href="#" className={styles.forgotten}>
//                     Vergeten ?
//                   </a>
//                 </Col>
//               </Row>
//               <Row>
//                 <Col md={{ span: 4, offset: 4 }}>
//                   <div className={styles.formButtons}>
//                     <button
//                       type="submit"
//                       data-test="submit"
//                       className={styles.firstBtn}
//                     >
//                       Inloggen
//                     </button>
//                     <Link to="/registreren" className={styles.link}>
//                       <button className={styles.secondBtn}>
//                         Account activeren
//                       </button>
//                     </Link>
//                   </div>
//                 </Col>
//               </Row>
//             </Container>
//             {this.state.error && (
//               <h3 data-test="error" onClick={this.dismissError}>
//                 <button onClick={this.dismissError}>✖</button>
//                 {this.state.error}
//               </h3>
//             )}
//           </div>
//         </Form>
//       </div>
//     );
//   }
// }

// export default LoginPage;
