"use client";
import React, { useEffect, useState } from "react";
import NcInputNumber from "@/components/NcInputNumber";
import { FC } from "react";
import { OccupancyObject } from "../type";

export interface OccupancyInputProps {
  defaultValue?: OccupancyObject;
  onChange?: (data: OccupancyObject) => void;
  className?: string;
}

const OccupancyInput: FC<OccupancyInputProps> = ({
  defaultValue,
  onChange,
  className = "",
}) => {
  const [roomsValue, setRoomsValue] = useState(defaultValue?.rooms || 1);
  const [adultsValue, setAdultsValue] = useState(defaultValue?.adults || 0);
  const [childrenValue, setChildrenValue] = useState(defaultValue?.children || 0);
  const [infantsValue, setInfantsValue] = useState(defaultValue?.infants || 0);

  useEffect(() => {
    setRoomsValue(defaultValue?.rooms || 1);
  }, [defaultValue?.rooms]);

  useEffect(() => {
    setAdultsValue(defaultValue?.adults || 0);
  }, [defaultValue?.adults]);

  useEffect(() => {
    setChildrenValue(defaultValue?.children || 0);
  }, [defaultValue?.children]);

  useEffect(() => {
    setInfantsValue(defaultValue?.infants || 0);
  }, [defaultValue?.infants]);

  const handleChangeData = (value: number, type: keyof OccupancyObject) => {
    let newValue = {
      rooms: roomsValue,
      adults: adultsValue,
      children: childrenValue,
      infants: infantsValue,
    };

    if (type === "rooms") {
      setRoomsValue(value);
      newValue.rooms = value;
    }

    if (type === "adults") {
      setAdultsValue(value);
      newValue.adults = value;
    }

    if (type === "children") {
      setChildrenValue(value);
      newValue.children = value;
    }

    if (type === "infants") {
      setInfantsValue(value);
      newValue.infants = value;
    }

    onChange && onChange(newValue);
  };

  return (
    <div className={`flex flex-col relative p-5 ${className}`}>
      <span className="mb-5 block font-semibold text-xl sm:text-2xl">
        Ai sẽ đi cùng bạn?
      </span>

      <NcInputNumber
        className="w-full"
        value={roomsValue}
        onChange={(value) => handleChangeData(value, "rooms")}
        min={1}
        max={10}
        label="Phòng"
        desc="Số lượng phòng"
      />

      <NcInputNumber
        className="w-full mt-6"
        value={adultsValue}
        onChange={(value) => handleChangeData(value, "adults")}
        max={20}
        label="Người lớn"
        desc="Từ 13 tuổi trở lên"
      />

      <NcInputNumber
        className="w-full mt-6"
        value={childrenValue}
        onChange={(value) => handleChangeData(value, "children")}
        max={10}
        label="Trẻ em"
        desc="Từ 2–12 tuổi"
      />

      <NcInputNumber
        className="w-full mt-6"
        value={infantsValue}
        onChange={(value) => handleChangeData(value, "infants")}
        max={10}
        label="Em bé"
        desc="Từ 0–2 tuổi"
      />
    </div>
  );
};

export default OccupancyInput;