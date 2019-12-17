import React, { Component } from "react";
import { Card, Form, Row, Col, Container } from "react-bootstrap";
import styles from "./styles.module.scss";
import { Link } from "react-router-dom";

class SignUpPage extends Component {
  state = {};
  render() {
    return (
      <div>
        <Card>
          <div className={styles.header}>
            <Card.Body>
              <Card.Title className={styles.title}>
                <span className={styles.forta}> FORTA </span> TASKMANAGER
              </Card.Title>
              <Card.Text></Card.Text>
            </Card.Body>
          </div>
        </Card>
        <Form onSubmit={this.handleSubmit}>
          <div className={styles.login}>
            <Container>
              <Row>
                <Col md={{ span: 5, offset: 4 }}>
                  <label className={styles.formLabel}>Registreren</label>
                </Col>
              </Row>
              <Row>
                <Col md={{ span: 5, offset: 4 }}>
                  <input
                    className={styles.input}
                    type="text"
                    data-test="username"
                    value={this.state.username}
                    onChange={this.handleUserChange}
                    placeholder="Gebruikersnaam"
                  />
                </Col>
              </Row>
              <Row>
                <Col md={{ span: 5, offset: 4 }}>
                  <input
                    className={styles.input}
                    type="password"
                    data-test="password"
                    value={this.state.password}
                    onChange={this.handlePassChange}
                    placeholder="Wachtwoord"
                  />
                </Col>
              </Row>
              <Row>
                <Col md={{ span: 5, offset: 4 }}>
                  <input
                    className={styles.input}
                    type="password"
                    data-test="password"
                    value={this.state.password}
                    onChange={this.handlePassChange}
                    placeholder="Herhaal Wachtwoord"
                  />
                </Col>
              </Row>
              <Row>
                <Col md={{ span: 5, offset: 4 }}>
                  <div className={styles.formButtons}>
                    <button
                      type="submit"
                      data-test="submit"
                      className={styles.firstBtn}
                    >
                      Account activeren
                    </button>
                    <Link to="/" className={styles.link}>
                      <button className={styles.secondBtn}>Inloggen</button>
                    </Link>
                  </div>
                </Col>
              </Row>
            </Container>
            {this.state.error && (
              <h3 data-test="error" onClick={this.dismissError}>
                <button onClick={this.dismissError}>✖</button>
                {this.state.error}
              </h3>
            )}
          </div>
        </Form>
      </div>
    );
  }
}

export default SignUpPage;
