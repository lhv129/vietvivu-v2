"use client";

import { MapPinIcon } from "@heroicons/react/24/outline";
import React, { useState, useRef, useEffect, FC, useMemo } from "react";
import ClearDataButton from "./ClearDataButton";
import { LOCATION_DEMO } from "@/data/locations";

export interface LocationItem {
  id: number;
  name: string;
}

export interface LocationInputProps {
  placeHolder?: string;
  desc?: string;
  className?: string;
  divHideVerticalLineClass?: string;
  autoFocus?: boolean;
  value?: string;
  onChange?: (value: LocationItem | null) => void;
}

const LocationInput: FC<LocationInputProps> = ({
  autoFocus = false,
  placeHolder = "Địa điểm",
  desc = "Bạn muốn đi đâu?",
  className = "nc-flex-1.5",
  divHideVerticalLineClass = "left-10 -right-0.5",
  value,
  onChange,
}) => {
  const containerRef = useRef<HTMLDivElement>(null);
  const inputRef = useRef<HTMLInputElement>(null);

  const [innerValue, setInnerValue] = useState(value || "");
  const [showPopover, setShowPopover] = useState(autoFocus);

  // sync value từ ngoài
  useEffect(() => {
    if (value !== undefined) {
      setInnerValue(value);
    }
  }, [value]);

  // autofocus
  useEffect(() => {
    if (showPopover) {
      inputRef.current?.focus();
    }
  }, [showPopover]);

  // click outside
  useEffect(() => {
    const handleClickOutside = (event: MouseEvent) => {
      if (!containerRef.current) return;

      if (!containerRef.current.contains(event.target as Node)) {
        setShowPopover(false);
      }
    };

    document.addEventListener("click", handleClickOutside);
    return () => document.removeEventListener("click", handleClickOutside);
  }, []);

  const handleSelectLocation = (item: LocationItem) => {
    setInnerValue(item.name);
    onChange?.(item);
    setShowPopover(false);
  };

  // filter location
  const filteredLocations = useMemo(() => {
    const keyword = innerValue.toLowerCase();

    return LOCATION_DEMO.filter((item) =>
      item.name.toLowerCase().includes(keyword)
    ).slice(0, 20); // tránh render quá nhiều
  }, [innerValue]);

  const renderLocations = () => (
    <>
      <h3 className="px-6 font-semibold text-base text-neutral-800 dark:text-neutral-100">
        Địa điểm
      </h3>

      <div className="mt-2">
        {filteredLocations.length > 0 ? (
          filteredLocations.map((item) => (
            <div
              key={item.id}
              onClick={() => handleSelectLocation(item)}
              className="flex items-center space-x-3 px-6 py-3 hover:bg-neutral-100 dark:hover:bg-neutral-700 cursor-pointer"
            >
              <MapPinIcon className="w-5 h-5 text-neutral-400" />

              <span className="font-medium text-neutral-700 dark:text-neutral-200">
                {item.name}
              </span>
            </div>
          ))
        ) : (
          <div className="px-6 py-4 text-neutral-400">Không tìm thấy địa điểm</div>
        )}
      </div>
    </>
  );

  return (
    <div className={`relative flex ${className}`} ref={containerRef}>
      <div
        onClick={() => setShowPopover(true)}
        className={`flex z-10 flex-1 relative nc-hero-field-padding items-center space-x-3 cursor-pointer ${showPopover ? "nc-hero-field-focused" : ""
          }`}
      >
        <MapPinIcon className="w-6 h-6 text-neutral-400" />

        <div className="flex-grow relative">
          <input
            ref={inputRef}
            value={innerValue}
            placeholder={placeHolder}
            autoFocus={showPopover}
            onChange={(e) => {
              const val = e.currentTarget.value;
              setInnerValue(val);
              onChange?.(null);
            }}
            className="w-full bg-transparent border-none focus:ring-0 p-0 outline-none xl:text-lg font-semibold placeholder-neutral-800 dark:placeholder-neutral-200 truncate"
          />

          <span className="block mt-0.5 text-sm text-neutral-400 font-light">
            {innerValue ? placeHolder : desc}
          </span>

          {innerValue && showPopover && (
            <ClearDataButton
              onClick={() => {
                setInnerValue("");
                onChange?.(null);
              }}
            />
          )}
        </div>
      </div>

      {showPopover && (
        <div
          className={`absolute left-0 z-40 w-full min-w-[300px] sm:min-w-[500px] bg-white dark:bg-neutral-800 top-full mt-3 py-4 rounded-3xl shadow-xl max-h-80 overflow-y-auto`}
        >
          {renderLocations()}
        </div>
      )}
    </div>
  );
};

export default LocationInput;