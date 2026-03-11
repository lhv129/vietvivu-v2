"use client";

import React, { FC } from "react";

export interface CheckboxProps {
  label?: string;
  subLabel?: string;
  className?: string;
  name: string;
  checked?: boolean;
  onChange?: (checked: boolean) => void;
}

const Checkbox: FC<CheckboxProps> = ({
  subLabel = "",
  label = "",
  name,
  className = "",
  checked = false,
  onChange,
}) => {
  return (
    <label
  className={`flex items-start text-sm sm:text-base cursor-pointer p-1 rounded-lg hover:bg-neutral-100 transition ${className}`}
>
      <input
        id={name}
        name={name}
        type="checkbox"
        checked={checked}
        onChange={(e) => onChange && onChange(e.target.checked)}
        className="focus:ring-primary-500 h-5 w-5 text-primary-600 border-neutral-300 rounded bg-white dark:bg-neutral-700 dark:checked:bg-primary-500"
      />

      {(label || subLabel) && (
        <span className="ml-3.5 flex flex-col flex-1">
          {label && (
            <span className="text-neutral-900 dark:text-neutral-100">
              {label}
            </span>
          )}

          {subLabel && (
            <span className="mt-1 text-neutral-500 dark:text-neutral-400 text-sm font-light">
              {subLabel}
            </span>
          )}
        </span>
      )}
    </label>
  );
};

export default Checkbox;