import React, { Component } from "react";
import { Row } from "react-bootstrap";
import Arrowdown from "../../assets/arrow-small-down.svg";
import Arrowup from "../../assets/arrow-small-up.svg";
import styles from "./styles.module.scss";
import Plus from "../../assets/plus.svg";

class Meeting extends Component {
  constructor(props) {
    super(props);
    this.state = { meetings: [] };
    this.handleSubmit = this.handleSubmit.bind(this);
  }

  createUI() {
    return this.state.meetings.map((el, i) => (
      <div key={i}>
        <input
          type="text"
          value={el || ""}
          className={styles.addMeetingInput}
          onChange={this.handleChange.bind(this, i)}
        />
        <input
          type="button"
          value="cancel"
          className={styles.cancelAddMeeting}
          onClick={this.removeClick.bind(this, i)}
        />
      </div>
    ));
  }

  handleChange(i, event) {
    let meetings = [...this.state.meetings];
    meetings[i] = event.target.value;
    this.setState({ meetings });
  }

  addClick() {
    this.setState(prevState => ({ meetings: [...prevState.meetings, ""] }));
  }

  removeClick(i) {
    let meetings = [...this.state.meetings];
    meetings.splice(i, 1);
    this.setState({ meetings });
  }

  // handleSubmit() {
  //   this.state.values.map(function(values) {
  //     return <li>{values}</li>;
  //   });
  // }
  handleSubmit(event) {
    alert(this.state.meetings.join(", ") + " meeting was successfully added.");
    event.preventDefault();
  }

  render() {
    return (
      <div style={{ lineHeight: 4.5 }}>
        <div>
          <h3 className={styles.header}>Vergaderingen</h3>

          <ul className={styles.scrollbar}>
            <div className={styles.ul}>
              <li>Hello! I'm the body</li>
              <li>Hello! I'm the body</li>
              <li>Hello! I'm the body</li>
              <li>Hello! I'm the body</li>
              <li>Hello! I'm the body</li>
              <li>Hello! I'm the body</li>
              <li>Hello! I'm the body</li>
              <li>Hello! I'm the body</li>
              <li>Hello! I'm the body</li>
              <li>Hello! I'm the body</li>
              <li>Hello! I'm the body</li>
              <li>Hello! I'm the body</li>
              <li>Hello! I'm the body</li>
              <li>Hello! I'm the body</li>
              <li>Hello! I'm the body</li>
              <li>Hello! I'm the body</li>
              <li>Hello! I'm the body</li>

              <div className={styles.addMeetingForm}>
                <form onSubmit={this.handleSubmit}>
                  {this.createUI()}
                  <button
                    className={styles.addBtn}
                    type="button"
                    onClick={this.addClick.bind(this)}
                  >
                    <Row>
                      <img src={Plus} alt=""></img>
                      <p className={styles.p}> Vergadering toevoegen</p>
                    </Row>
                  </button>
                </form>
              </div>
              {/* <li>Hello! I'm the body</li>
                <li>Hello! I'm the body</li>
                <li>Hello! I'm the body</li>
                <li>Hello! I'm the body</li>
                <li>Hello! I'm the body</li>
                <li>Hello! I'm the body</li>
                <li>Hello! I'm the body</li>
                <li>Hello! I'm the body</li>
                <li>Hello! I'm the body</li>
                <li>Hello! I'm the body</li>
                <li>Hello! I'm the body</li>
                <li>Hello! I'm the body</li>
                <li>Hello! I'm the body</li>
                <li>Hello! I'm the body</li> */}
            </div>
          </ul>
        </div>
      </div>
    );
  }
}

export default Meeting;

// constructor(props) {
//   super(props);
//   this.state = { meetings: [] };
// }

// save() {
//   var meetings = [...this.state.meetings];
//   meetings.push(this.newText.value);
//   this.setState({ meetings });
// }
// render() {
//   return (
//     <div style={{ lineHeight: 4.5 }}>
//       <div>
//         <h3 className={styles.header}>Vergaderingen</h3>
//         <input
//           type="text"
//           ref={ip => {
//             this.newText = ip;
//           }}
//         />
//         <button
//           onClick={this.save.bind(this)}
//           className="btn btn-primary glyphicon glyphicon-floppy-saved"
//         >
//           Save
//         </button>
//         <ul>
//           {this.state.meetings.map(function(meeting) {
//             return <li>{meeting}</li>;
//           })}
//         </ul>
//       </div>
//     </div>
//   );
// }
