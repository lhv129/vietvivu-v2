import React from "react";
import Button, { ButtonProps } from "./Button";

export interface ButtonThirdProps extends ButtonProps { }

const ButtonThird: React.FC<ButtonThirdProps> = ({
  className,
  ...props
}) => {
  return (
    <Button
      className={`ttnc-ButtonThird text-neutral-700 border border-neutral-200 dark:text-neutral-200 dark:border-neutral-700 ${className ?? ""}`}
      {...props}
    />
  );
};

export default ButtonThird;