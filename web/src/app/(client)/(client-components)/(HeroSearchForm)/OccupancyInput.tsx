"use client";

import React, { Fragment } from "react";
import { Popover, Transition } from "@headlessui/react";
import NcInputNumber from "@/components/NcInputNumber";
import { FC } from "react";
import ClearDataButton from "./ClearDataButton";
import ButtonSubmit from "./ButtonSubmit";
import { PathName } from "@/routers/types";
import { UserPlusIcon } from "@heroicons/react/24/outline";
import { OccupancyObject } from "../type";

export interface OccupancyInputProps {
  fieldClassName?: string;
  className?: string;
  buttonSubmitHref?: PathName;
  hasButtonSubmit?: boolean;
  value: OccupancyObject;
  onChange: (data: OccupancyObject) => void;
}

const OccupancyInput: FC<OccupancyInputProps> = ({
  fieldClassName = "[ nc-hero-field-padding ]",
  className = "[ nc-flex-1 ]",
  buttonSubmitHref = "/listing-stay-map",
  hasButtonSubmit = true,
  value,
  onChange,
}) => {
  const { rooms, adults, children, infants } = value;

  const totalGuests = adults + children;

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

  return (
    <Popover className={`flex relative ${className}`}>
      {({ open }) => (
        <>
          <div
            className={`flex-1 z-10 flex items-center focus:outline-none ${open ? "nc-hero-field-focused" : ""
              }`}
          >
            <Popover.Button
              className={`relative z-10 flex-1 flex text-left items-center ${fieldClassName} space-x-3 focus:outline-none`}
            > <div className="text-neutral-300 dark:text-neutral-400"> <UserPlusIcon className="w-5 h-5 lg:w-7 lg:h-7" /> </div>
              <div className="flex-grow">
                <span className="block xl:text-lg font-semibold">
                  {rooms} Phòng
                </span>

                <span className="block mt-1 text-sm text-neutral-400 leading-none font-light">
                  {totalGuests} Khách {children > 0 && `, ${children} Trẻ em`}
                </span>
              </div>

              {!!totalGuests && open && (
                <ClearDataButton onClick={clearData} />
              )}
            </Popover.Button>

            {/* NÚT TÌM KIẾM */}
            {hasButtonSubmit && (
              <div className="pr-2 xl:pr-4">
                <ButtonSubmit href={buttonSubmitHref} />
              </div>
            )}
          </div>

          {open && (
            <div className="h-8 absolute self-center top-1/2 -translate-y-1/2 z-0 -left-0.5 right-0.5 bg-white dark:bg-neutral-800"></div>
          )}

          <Transition
            as={Fragment}
            enter="transition ease-out duration-200"
            enterFrom="opacity-0 translate-y-1"
            enterTo="opacity-100 translate-y-0"
            leave="transition ease-in duration-150"
            leaveFrom="opacity-100 translate-y-0"
            leaveTo="opacity-0 translate-y-1"
          >
            <Popover.Panel className="absolute right-0 z-10 w-full sm:min-w-[340px] max-w-sm bg-white dark:bg-neutral-800 top-full mt-3 py-5 sm:py-6 px-4 sm:px-8 rounded-3xl shadow-xl">

              <NcInputNumber
                className="w-full"
                value={rooms}
                onChange={(v) => updateValue("rooms", v)}
                min={1}
                max={10}
                label="Phòng"
                desc="Số lượng phòng"
              />

              <NcInputNumber
                className="w-full mt-6"
                value={adults}
                onChange={(v) => updateValue("adults", v)}
                min={1}
                max={10}
                label="Người lớn"
                desc="Từ 13 tuổi trở lên"
              />

              <NcInputNumber
                className="w-full mt-6"
                value={children}
                onChange={(v) => updateValue("children", v)}
                max={4}
                label="Trẻ em"
                desc="Từ 2–12 tuổi"
              />

              <NcInputNumber
                className="w-full mt-6"
                value={infants}
                onChange={(v) => updateValue("infants", v)}
                max={4}
                label="Em bé"
                desc="Từ 0–2 tuổi"
              />

            </Popover.Panel>
          </Transition>
        </>
      )}
    </Popover>

  );
};

export default OccupancyInput;
