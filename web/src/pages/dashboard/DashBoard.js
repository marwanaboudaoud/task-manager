import React, { Component } from "react";
import MyTask from "../../components/myTask/MyTask";
import Archive from "../../components/archive/Archive";
import Meeting from "../../components/meetings/Meeting";
import styles from "./styles.module.scss";
import MenuLogo from "../../assets/menu.svg";
import Notepad from "../../components/Notepad/index";
import { Row, Col, ListGroup, Container, Navbar, Nav } from "react-bootstrap";

class DashBoard extends Component {
  render() {
    return (
      <div>
        <Row>
          <Col md={3} xs={12} className={styles.dashboardcontainer}>
            <Nav className="flex-column">
              <Navbar expand="lg" className={styles.nav}>
                <div>
                  <Navbar.Brand className="navHome">
                    <Row>
                      <img src={MenuLogo} alt="" className={styles.menuLogo} />
                      <h5>
                        <span className={styles.forta}> FORTA </span>{" "}
                        TASKMANAGER
                      </h5>
                    </Row>
                  </Navbar.Brand>
                  <Navbar.Toggle aria-controls="basic-navbar-nav" />
                  <Navbar.Collapse id="basic-navbar-nav ">
                    <div className={styles.scrollbar}>
                      <Nav className="flex-column">
                        <Nav.Link>
                          <MyTask />
                        </Nav.Link>
                        <Nav.Link>
                          <Meeting />
                        </Nav.Link>
                      </Nav>
                    </div>
                  </Navbar.Collapse>
                </div>
              </Navbar>
            </Nav>
          </Col>
          <Col md={9}>
            <h1>Hello i'm the H1</h1>
          </Col>
        </Row>

        <Notepad />
      </div>
    );
  }
}

export default DashBoard;
