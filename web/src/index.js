import React from "react";
import ReactDOM from "react-dom";
import { BrowserRouter as Router, Route } from "react-router-dom";
import MyTask from "./components/myTask/MyTask";
import LoginPage from "./pages/login/Login";
import SignUpPage from "./pages/signUp/SignUp";
import DashBoard from "./pages/dashboard/DashBoard";
import Notepad from "./components/Notepad/index";
import Test from "./components/test";
import "./index.css";
import "bootstrap/dist/css/bootstrap.min.css";
import "@fortawesome/fontawesome-free/css/all.min.css";
import "bootstrap-css-only/css/bootstrap.min.css";
import "mdbreact/dist/css/mdb.css";

ReactDOM.render(
  <Router>
    <div>
      <Route exact path="/" component={LoginPage} />
      <Route path="/registreren" component={SignUpPage} />
      <Route path="/mytask" component={MyTask} />
      <Route path="/dashBoard" component={DashBoard} />
      <Route path="/notepad" component={Notepad} />
      <Route path="/test" component={Test} />
    </div>
  </Router>,
  document.getElementById("root")
);
