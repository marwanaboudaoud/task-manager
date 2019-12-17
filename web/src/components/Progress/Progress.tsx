import React from "react";
import Progress from "@material-ui/core/CircularProgress";
import Typography from "@material-ui/core/Typography";
import Paper from "@material-ui/core/Paper";
import Divider from "@material-ui/core/Divider";

const Loader = ({
  message,
  visible = false
}: {
  message: string;
  visible?: boolean;
}) => {
  return (
    <React.Fragment>
      {visible ? (
        <Paper
          style={{
            backgroundColor: "rgba(255,255,255,0.8)",
            width: "100%",
            height: "100%",
            zIndex: 200,
            position: "absolute",
            top: 0,
            left: 0,
            display: "flex",
            alignItems: "center",
            justifyContent: "center",
            flexDirection: "column"
          }}
        >
          <Progress color="secondary" />
          <Divider />
          <Typography variant="body2">{message}</Typography>
        </Paper>
      ) : (
        <span />
      )}
    </React.Fragment>
  );
};

export default Loader;
