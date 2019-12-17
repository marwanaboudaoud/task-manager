import React, { Component } from "react";

const ListItem = ({ value, onClick }) => <li onClick={onClick}>{value}</li>;

const List = ({ items, onItemClick }) => (
  <ul>
    {items.map((item, i) => (
      <ListItem key={i} value={item} onClick={onItemClick} />
    ))}
  </ul>
);

class Test extends React.Component {
  constructor(props) {
    super(props);
    this.state = {
      inputValue: "",
      fruites: ["Apple", "Banana", "Orange"]
    };
  }

  onClick = () => {
    const { inputValue, fruites } = this.state;
    if (inputValue) {
      const nextState = [...fruites, inputValue];
      this.setState({ fruites: nextState, inputValue: "" });
    }
  };

  onChange = e => this.setState({ inputValue: e.target.value });

  handleItemClick = e => {
    console.log(e.target.innerHTML);
  };

  render() {
    const { fruites, inputValue } = this.state;
    return (
      <div>
        <form onSubmit={this.handleSubmit}>
          <button type="button" onClick={this.onClick}>
            >{/* <Row> */}
            {/* <img src={Plus} alt=""></img> */}
            <p> Vergadering toevoegen</p>
            {/* </Row> */}
          </button>
        </form>
        <input type="text" value={inputValue} onChange={this.onChange} />
        <button onClick={this.onClick}>Add</button>
        <div>
          <input type="text" placeholder="Vul hier de naam in" />
          <input type="button" value="cancel" />
        </div>
      </div>
    );
  }
}

export default Test;
