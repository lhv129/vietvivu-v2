"use client";

import DatePicker from "react-datepicker";
import React, { FC } from "react";
import { registerLocale } from "react-datepicker";
import { vi } from "date-fns/locale";

import DatePickerCustomHeaderTwoMonth from "@/components/DatePickerCustomHeaderTwoMonth";
import DatePickerCustomDay from "@/components/DatePickerCustomDay";

registerLocale("vi", vi);

export interface StayDatesRangeInputProps {
  className?: string;
  startDate: Date | null;
  endDate: Date | null;
  onChange: (dates: [Date | null, Date | null]) => void;
}

const StayDatesRangeInput: FC<StayDatesRangeInputProps> = ({
  className = "",
  startDate,
  endDate,
  onChange,
}) => {
  return (
    <div>
      <div className="p-5">
        <span className="block font-semibold text-xl sm:text-2xl">
          Khi nào bạn đi du lịch?
        </span>
      </div>

      <div
        className={`relative flex-shrink-0 flex justify-center z-10 py-5 ${className}`}
      >
        <DatePicker
          locale="vi"
          selected={startDate}
          onChange={(dates) => onChange(dates as [Date | null, Date | null])}
          startDate={startDate}
          endDate={endDate}
          selectsRange
          monthsShown={2}
          showPopperArrow={false}
          inline
          minDate={new Date()}
          renderCustomHeader={(p) => (
            <DatePickerCustomHeaderTwoMonth {...p} />
          )}
          renderDayContents={(day, date) => (
            <DatePickerCustomDay dayOfMonth={day} date={date} />
          )}
        />
      </div>
    </div>
  );
};

export default StayDatesRangeInput;