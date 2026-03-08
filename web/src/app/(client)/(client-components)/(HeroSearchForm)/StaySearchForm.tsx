"use client";

import React, { FC, useState } from "react";
import LocationInput from "./LocationInput";
import Occupancy from "./OccupancyInput";
import StayDatesRangeInput from "./StayDatesRangeInput";

export interface occupancyObject {
  rooms: number;
  adults: number;
  children: number;
  infants: number;
}

const StaySearchForm: FC = () => {
  const [location, setLocation] = useState<{ id: number; name: string } | null>(
    null
  );

  const [dates, setDates] = useState<[Date | null, Date | null]>([null, null]);

  const [occupancy, setOccupancy] = useState<occupancyObject>({
    rooms: 1,
    adults: 2,
    children: 1,
    infants: 1,
  });

  const formatDate = (date: Date | null) =>
    date
      ? `${date.getFullYear()}-${(date.getMonth() + 1)
        .toString()
        .padStart(2, "0")}-${date.getDate().toString().padStart(2, "0")}`
      : null;

  const handleSubmit = (e: React.FormEvent) => {
    e.preventDefault();

    const [startDate, endDate] = dates;

    const payload = {
      location_id: location?.id || null,
      check_in: formatDate(startDate),
      check_out: formatDate(endDate),
      ...occupancy
    };
    console.log("Payload:", payload);
  };

  return (<form
    onSubmit={handleSubmit}
    className="w-full relative mt-8 flex items-center rounded-full shadow-xl bg-white dark:bg-neutral-800"
  >
    {/* LOCATION */}
    <LocationInput
      className="flex-[1.5]"
      value={location?.name || ""}
      onChange={setLocation}
    />

    < div className="self-center border-r border-slate-200 dark:border-slate-700 h-8" ></div >

    {/* DATE RANGE */}
    < StayDatesRangeInput
      className="flex-1"
      value={dates}
      onChange={setDates}
    />

    <div className="self-center border-r border-slate-200 dark:border-slate-700 h-8"></div>

    {/* GUESTS + ROOMS */}
    <Occupancy
      className="flex-1"
      value={occupancy}
      onChange={setOccupancy}
    />
  </form >
  );
};

export default StaySearchForm;
