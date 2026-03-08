"use client";

import { MapPinIcon, MagnifyingGlassIcon } from "@heroicons/react/24/outline";
import React, { useState, useEffect, useRef, FC, useMemo } from "react";
import { LOCATION_DEMO } from "@/data/locations";
import { LocationItem } from "@/data/locations";

interface Props {
  onClick?: () => void;
  onChange?: (value: LocationItem | null) => void;
  className?: string;
  defaultValue?: string;
  headingText?: string;
}

const LocationInput: FC<Props> = ({
  onChange = () => { },
  className = "",
  defaultValue = "",
  headingText = "Bạn muốn đi đâu?",
}) => {
  const [value, setValue] = useState("");
  const [showPopover, setShowPopover] = useState(false);

  const containerRef = useRef<HTMLDivElement>(null);
  const inputRef = useRef<HTMLInputElement>(null);

  useEffect(() => {
    setValue(defaultValue);
  }, [defaultValue]);

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
    setValue(item.name);
    onChange(item);
    setShowPopover(false);
  };

  const filteredLocations = useMemo(() => {
    const keyword = value.toLowerCase();

    return LOCATION_DEMO.filter((item) =>
      item.name.toLowerCase().includes(keyword)
    );
  }, [value]);

  const renderLocations = () => {
    return (
      <>
        <p className="block font-semibold text-base">Địa điểm</p>

        <div className="mt-3 max-h-60 overflow-y-auto">
          {filteredLocations.length > 0 ? (
            filteredLocations.map((item) => (
              <div
                className="py-2 mb-1 flex items-center space-x-3 text-sm"
                onClick={() => handleSelectLocation(item)}
                key={item.id}
              >
                <MapPinIcon className="w-5 h-5 text-neutral-500 dark:text-neutral-400" />
                <span>{item.name}</span>
              </div>
            ))
          ) : (
            <div className="text-sm text-neutral-400 py-2">
              Không tìm thấy địa điểm
            </div>
          )}
        </div>
      </>
    );
  };

  return (
    <div className={`${className}`} ref={containerRef}>
      <div className="p-5">
        <span className="block font-semibold text-xl sm:text-2xl">
          {headingText}
        </span>

        <div className="relative mt-5">
          <input
            className="block w-full bg-transparent border px-4 py-3 pr-12 border-neutral-900 dark:border-neutral-200 rounded-xl focus:ring-0 focus:outline-none text-base leading-none placeholder-neutral-500 dark:placeholder-neutral-300 truncate font-bold placeholder:truncate"
            placeholder={"Tìm kiếm địa điểm"}
            value={value}
            onFocus={() => setShowPopover(true)}
            onChange={(e) => {
              setValue(e.currentTarget.value);
              onChange(null);
            }}
            ref={inputRef}
          />

          <span className="absolute right-2.5 top-1/2 -translate-y-1/2">
            <MagnifyingGlassIcon className="w-5 h-5 text-neutral-700 dark:text-neutral-400" />
          </span>
        </div>

        {showPopover && <div className="mt-7">{renderLocations()}</div>}
      </div>
    </div>
  );
};

export default LocationInput;