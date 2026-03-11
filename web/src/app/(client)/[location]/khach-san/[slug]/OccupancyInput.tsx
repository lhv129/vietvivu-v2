"use client";

import React, { Fragment, FC } from "react";
import { Popover, Transition } from "@headlessui/react";
import NcInputNumber from "@/components/NcInputNumber";
import { UserPlusIcon } from "@heroicons/react/24/outline";
import ClearDataButton from "@/app/(client)/(client-components)/(HeroSearchForm)/ClearDataButton";
import { OccupancyObject } from "@/app/(client)/(client-components)/type";

export interface OccupancyInputProps {
  className?: string;
  value: OccupancyObject;
  onChange: (data: OccupancyObject) => void;
}

const OccupancyInput: FC<OccupancyInputProps> = ({
  className = "flex-1",
  value,
  onChange,
}) => {
  const { adults, children, infants, rooms } = value;

  const updateValue = (key: keyof OccupancyObject, newValue: number) => {
    onChange({
      ...value,
      [key]: newValue,
    });
  };

  const clearData = () => {
    onChange({
      rooms: 1,
      adults: 0,
      children: 0,
      infants: 0,
    });
  };

  const totalGuests = adults + children + infants;

  return (
    <Popover className={`flex relative ${className}`}>
      {({ open }) => (
        <>
          <div
            className={`flex-1 flex items-center focus:outline-none rounded-b-3xl ${open ? "shadow-lg" : ""
              }`}
          >
            <Popover.Button
              className="relative z-10 flex-1 flex text-left items-center p-3 space-x-3 focus:outline-none"
            >
              <div className="text-neutral-300 dark:text-neutral-400">
                <UserPlusIcon className="w-5 h-5 lg:w-7 lg:h-7" />
              </div>

              <div className="flex-grow">
                <span className="block xl:text-lg font-semibold">
                  {totalGuests || ""} Guests
                </span>

                <span className="block mt-1 text-sm text-neutral-400 leading-none font-light">
                  {totalGuests ? `${rooms} Rooms` : "Add guests"}
                </span>
              </div>

              {!!totalGuests && open && (
                <ClearDataButton onClick={clearData} />
              )}
            </Popover.Button>
          </div>

          <Transition
            as={Fragment}
            enter="transition ease-out duration-200"
            enterFrom="opacity-0 translate-y-1"
            enterTo="opacity-100 translate-y-0"
            leave="transition ease-in duration-150"
            leaveFrom="opacity-100 translate-y-0"
            leaveTo="opacity-0 translate-y-1"
          >
            <Popover.Panel className="absolute right-0 z-10 w-full sm:min-w-[340px] max-w-sm bg-white dark:bg-neutral-800 top-full mt-3 py-5 sm:py-6 px-4 sm:px-8 rounded-3xl shadow-xl ring-1 ring-black ring-opacity-5 ">

              <NcInputNumber
                className="w-full"
                value={rooms}
                onChange={(v) => updateValue("rooms", v)}
                min={1}
                max={10}
                label="Rooms"
                desc="Number of rooms"
              />

              <NcInputNumber
                className="w-full mt-6"
                value={adults}
                onChange={(v) => updateValue("adults", v)}
                max={10}
                min={1}
                label="Adults"
                desc="Ages 13 or above"
              />

              <NcInputNumber
                className="w-full mt-6"
                value={children}
                onChange={(v) => updateValue("children", v)}
                max={4}
                label="Children"
                desc="Ages 2–12"
              />

              <NcInputNumber
                className="w-full mt-6"
                value={infants}
                onChange={(v) => updateValue("infants", v)}
                max={4}
                label="Infants"
                desc="Ages 0–2"
              />

            </Popover.Panel>
          </Transition>
        </>
      )}
    </Popover>
  );
};

export default OccupancyInput;