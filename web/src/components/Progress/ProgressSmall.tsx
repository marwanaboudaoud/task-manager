import React from "react";
import Progress from "@material-ui/core/CircularProgress";

const Loader = ({
  visible = false,
  style = {},
}: {
  message: string;
  visible?: boolean;
  style?: Object;
}) => {
  return (
    <React.Fragment>
      {visible ? <Progress color="secondary" style={style} /> : <span />}
    </React.Fragment>
  );
};

export default Loader;
