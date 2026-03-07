"use client";

import { ClockIcon, MapPinIcon } from "@heroicons/react/24/outline";
import React, { useState, useRef, useEffect, FC } from "react";
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
  onChange?: (value: { id: number; name: string } | null) => void;
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

  useEffect(() => {
    setShowPopover(autoFocus);
  }, [autoFocus]);

  useEffect(() => {
    if (value !== undefined) {
      setInnerValue(value);
    }
  }, [value]);

  const eventClickOutsideDiv = (event: MouseEvent) => {
    if (!containerRef.current) return;
    if (!showPopover || containerRef.current.contains(event.target as Node)) {
      return;
    }
    setShowPopover(false);
  };

  useEffect(() => {
    document.addEventListener("click", eventClickOutsideDiv);
    return () => {
      document.removeEventListener("click", eventClickOutsideDiv);
    };
  }, [showPopover]);

  useEffect(() => {
    if (showPopover && inputRef.current) {
      inputRef.current.focus();
    }
  }, [showPopover]);

  const handleSelectLocation = (item: LocationItem) => {
    setInnerValue(item.name);
    onChange?.(item);
    setShowPopover(false);
  };

  const filteredLocations = LOCATION_DEMO.filter((item) =>
    item.name.toLowerCase().includes(innerValue.toLowerCase())
  );


  const renderLocations = () => (
    <>
      <h3 className="block mt-2 sm:mt-0 px-4 sm:px-8 font-semibold text-base sm:text-lg text-neutral-800 dark:text-neutral-100">
        Địa điểm
      </h3>

      <div className="mt-2">
        {filteredLocations.length > 0 ? (
          filteredLocations.map((item) => (
            <span
              onClick={() => handleSelectLocation(item)}
              key={item.id}
              className="flex px-4 sm:px-8 items-center space-x-3 sm:space-x-4 py-4 hover:bg-neutral-100 dark:hover:bg-neutral-700 cursor-pointer"
            >
              <span className="block text-neutral-400">
                <MapPinIcon className="h-4 sm:h-6 w-4 sm:w-6" />
              </span>

              <span className="block font-medium text-neutral-700 dark:text-neutral-200">
                {item.name}
              </span>
            </span>
          ))
        ) : (
          <div className="px-6 py-4 text-neutral-400">
            Không tìm thấy
          </div>
        )}
      </div>
    </>
  );

  return (
    <div className={`relative flex ${className}`} ref={containerRef}>
      <div
        onClick={() => setShowPopover(true)}
        className={`flex z-10 flex-1 relative [ nc-hero-field-padding ] flex-shrink-0 items-center space-x-3 cursor-pointer focus:outline-none text-left ${showPopover ? "nc-hero-field-focused" : ""
          }`}
      >
        <div className="text-neutral-300 dark:text-neutral-400">
          <MapPinIcon className="w-5 h-5 lg:w-7 lg:h-7" />
        </div>

        <div className="flex-grow">
          <input
            className="block w-full bg-transparent border-none focus:ring-0 p-0 focus:outline-none focus:placeholder-neutral-300 xl:text-lg font-semibold placeholder-neutral-800 dark:placeholder-neutral-200 truncate"
            placeholder={placeHolder}
            value={innerValue}
            autoFocus={showPopover}
            onChange={(e) => {
              const val = e.currentTarget.value;
              setInnerValue(val);
              onChange?.(null);
            }}
            ref={inputRef}
          />

          <span className="block mt-0.5 text-sm text-neutral-400 font-light">
            <span className="line-clamp-1">
              {!!innerValue ? placeHolder : desc}
            </span>
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
          className={`h-8 absolute self-center top-1/2 -translate-y-1/2 z-0 bg-white dark:bg-neutral-800 ${divHideVerticalLineClass}`}
        ></div>
      )}

      {showPopover && (
        <div className="absolute left-0 z-40 w-full min-w-[300px] sm:min-w-[500px] bg-white dark:bg-neutral-800 top-full mt-3 py-3 sm:py-6 rounded-3xl shadow-xl max-h-96 overflow-y-auto">
          {renderLocations()}
        </div>
      )}
    </div>
  );
};

export default LocationInput;