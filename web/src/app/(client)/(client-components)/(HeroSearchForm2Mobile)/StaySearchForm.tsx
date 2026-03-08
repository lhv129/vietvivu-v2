"use client";

import converSelectedDateToString from "@/utils/converSelectedDateToString";
import React, { useState, FC } from "react";
import { OccupancyObject } from "../type";
import OccupancyInput from "./OccupancyInput";
import LocationInput from "./LocationInput";
import DatesRangeInput from "./DatesRangeInput";
import { LocationItem } from "@/data/locations";

interface Props {
  location: LocationItem | null;
  setLocation: React.Dispatch<React.SetStateAction<LocationItem | null>>;
  startDate: Date | null;
  endDate: Date | null;
  setDates: (dates: [Date | null, Date | null]) => void;
  guests: OccupancyObject;
  setGuests: (value: OccupancyObject) => void;
}

const StaySearchForm: FC<Props> = ({
  location,
  setLocation,
  startDate,
  endDate,
  setDates,
  guests,
  setGuests,
}) => {
  const [fieldNameShow, setFieldNameShow] = useState<
    "location" | "dates" | "guests"
  >("location");

  const handleSubmit = () => {
    const payload = {
      location,
      check_in: startDate ? converSelectedDateToString(startDate) : null,
      check_out: endDate ? converSelectedDateToString(endDate) : null,
      ...guests,
    };

    console.log("SEARCH PAYLOAD:", payload);
  };

  const renderInputLocation = () => {
    const isActive = fieldNameShow === "location";

    return (
      <div
        className={`w-full bg-white dark:bg-neutral-800 ${isActive
          ? "rounded-2xl shadow-lg"
          : "rounded-xl shadow-[0px_2px_2px_0px_rgba(0,0,0,0.25)]"
          }`}
      >
        {!isActive ? (
          <button
            className="w-full flex justify-between text-sm font-medium p-4"
            onClick={() => setFieldNameShow("location")}
          >
            <span className="text-neutral-400">Nơi đến</span>
            <span>{location?.name || "Chọn địa điểm"}</span>
          </button>
        ) : (
          <LocationInput
            defaultValue={location?.name}
            onChange={(value) => {
              setLocation(value);
              setFieldNameShow("dates");
            }}
          />
        )}
      </div>
    );
  };

  const renderInputDates = () => {
    const isActive = fieldNameShow === "dates";

    return (
      <div
        className={`w-full bg-white dark:bg-neutral-800 overflow-hidden ${isActive
          ? "rounded-2xl shadow-lg"
          : "rounded-xl shadow-[0px_2px_2px_0px_rgba(0,0,0,0.25)]"
          }`}
      >
        {!isActive ? (
          <button
            className="w-full flex justify-between text-sm font-medium p-4"
            onClick={() => setFieldNameShow("dates")}
          >
            <span className="text-neutral-400">Ngày</span>
            <span>
              {startDate
                ? `${startDate.getDate()} Th${startDate.getMonth() + 1}${endDate
                  ? ` - ${endDate.getDate()} Th${endDate.getMonth() + 1}`
                  : ""
                }`
                : "Chọn ngày"}
            </span>
          </button>
        ) : (
          <DatesRangeInput
            startDate={startDate}
            endDate={endDate}
            onChange={(dates) => {
              setDates(dates);

              const [, end] = dates;

              if (end) {
                setFieldNameShow("guests");
              }
            }}
          />
        )}
      </div>
    );
  };

  const renderInputGuests = () => {
    const isActive = fieldNameShow === "guests";

    let guestSelected = "";

    const totalGuests = guests.adults + guests.children;

    if (guests.rooms || totalGuests) {
      guestSelected = `${guests.rooms} phòng, ${totalGuests} khách`;
    }

    return (
      <div
        className={`w-full bg-white dark:bg-neutral-800 overflow-hidden ${isActive
          ? "rounded-2xl shadow-lg"
          : "rounded-xl shadow-[0px_2px_2px_0px_rgba(0,0,0,0.25)]"
          }`}
      >
        {!isActive ? (
          <button
            className="w-full flex justify-between text-sm font-medium p-4"
            onClick={() => setFieldNameShow("guests")}
          >
            <span className="text-neutral-400">Khách</span>
            <span>{guestSelected || `Thêm khách`}</span>
          </button>
        ) : (
          <OccupancyInput defaultValue={guests} onChange={setGuests} />
        )}
      </div>
    );
  };

  return (
    <div>
      <div className="w-full space-y-5">
        {renderInputLocation()}
        {renderInputDates()}
        {renderInputGuests()}
      </div>
    </div>
  );
};

export default StaySearchForm;