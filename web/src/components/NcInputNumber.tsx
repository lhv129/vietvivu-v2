"use client";

import React, { FC } from "react";
import { MinusIcon, PlusIcon } from "@heroicons/react/24/solid";

export interface NcInputNumberProps {
  className?: string;
  value?: number;
  min?: number;
  max?: number;
  onChange?: (value: number) => void;
  label?: string;
  desc?: string;
}

const NcInputNumber: FC<NcInputNumberProps> = ({
  className = "w-full",
  value = 0,
  min = 0,
  max,
  onChange,
  label,
  desc,
}) => {
  const decrement = () => {
    if (value <= min) return;
    onChange?.(value - 1);
  };

  const increment = () => {
    if (max && value >= max) return;
    onChange?.(value + 1);
  };

  return (
    <div className={`flex items-center justify-between ${className}`}>
      <div className="flex flex-col">
        <span className="font-medium text-neutral-800 dark:text-neutral-200">
          {label}
        </span>

        {desc && (
          <span className="text-xs text-neutral-500 dark:text-neutral-400">
            {desc}
          </span>
        )}
      </div>

      <div className="flex items-center space-x-3">
        <button
          type="button"
          onClick={decrement}
          className="w-8 h-8 rounded-full flex items-center justify-center border"
        >
          <MinusIcon className="w-4 h-4" />
        </button>

        <span>{value}</span>

        <button
          type="button"
          onClick={increment}
          className="w-8 h-8 rounded-full flex items-center justify-center border"
        >
          <PlusIcon className="w-4 h-4" />
        </button>
      </div>
    </div>
  );
};

export default NcInputNumber;