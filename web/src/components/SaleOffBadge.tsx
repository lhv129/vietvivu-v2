import React, { FC } from "react";

export interface SaleOffBadgeProps {
  className?: string;
  text?: string;
}

const SaleOffBadge: FC<SaleOffBadgeProps> = ({
  className = "",
  text = "-10%",
}) => {
  return (
    <div
      data-nc-id="SaleOffBadge"
      className={`nc-SaleOffBadge flex items-center justify-center text-xs font-medium py-0.5 px-3 bg-red-600 text-white rounded-full ${className}`}
    >
      {text}
    </div>
  );
};

export default SaleOffBadge;