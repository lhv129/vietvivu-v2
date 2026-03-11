"use client";

import React, { FC, useEffect, useState } from "react";
import { LocationItem } from "@/data/locations";
import CardCategory3 from "@/components/CardCategory3";
import Heading from "@/shared/Heading";
import { AnimatePresence, motion, MotionConfig } from "framer-motion";
import { useSwipeable } from "react-swipeable";
import PrevBtn from "./PrevBtn";
import NextBtn from "./NextBtn";
import { variants } from "@/utils/animationVariants";
import { useWindowSize } from "react-use";
import type { Route } from "next";

export interface SectionSliderNewLocationsProps {
  className?: string;
  itemClassName?: string;
  heading?: string;
  subHeading?: string;
  locations: LocationItem[];
  itemPerRow?: 4 | 5;
  sliderStyle?: "style1" | "style2";
}

const SectionSliderNewLocations: FC<SectionSliderNewLocationsProps> = ({
  heading = "Khám phá điểm đến",
  subHeading = "Những địa điểm du lịch phổ biến dành cho bạn",
  className = "",
  itemClassName = "",
  locations,
  itemPerRow = 5,
  sliderStyle = "style1",
}) => {
  const [currentIndex, setCurrentIndex] = useState(0);
  const [direction, setDirection] = useState(0);
  const [numberOfItems, setNumberOfitem] = useState(0);

  const windowWidth = useWindowSize().width;

  useEffect(() => {
    if (windowWidth < 320) return setNumberOfitem(1);
    if (windowWidth < 500) return setNumberOfitem(itemPerRow - 3);
    if (windowWidth < 1024) return setNumberOfitem(itemPerRow - 2);
    if (windowWidth < 1280) return setNumberOfitem(itemPerRow - 1);

    setNumberOfitem(itemPerRow);
  }, [itemPerRow, windowWidth]);

  function changeItemId(newVal: number) {
    setDirection(newVal > currentIndex ? 1 : -1);
    setCurrentIndex(newVal);
  }

  const handlers = useSwipeable({
    onSwipedLeft: () => {
      if (currentIndex < locations.length - 1) {
        changeItemId(currentIndex + 1);
      }
    },
    onSwipedRight: () => {
      if (currentIndex > 0) {
        changeItemId(currentIndex - 1);
      }
    },
    trackMouse: true,
  });

  if (!numberOfItems) return null;

  return (
    <div className={`nc-SectionSliderNewLocations ${className}`}>
      <Heading desc={subHeading} isCenter={sliderStyle === "style2"}>
        {heading}
      </Heading>

      <MotionConfig
        transition={{
          x: { type: "spring", stiffness: 300, damping: 30 },
          opacity: { duration: 0.2 },
        }}
      >
        <div className="relative flow-root" {...handlers}>
          <div className="flow-root overflow-hidden rounded-xl">
            <motion.ul
              initial={false}
              className="relative whitespace-nowrap -mx-2 xl:-mx-4"
              {...({} as any)}
            >
              <AnimatePresence initial={false} custom={direction}>
                {locations.map((item, indx) => (
                  <motion.li
                    key={indx}
                    className={`relative inline-block px-2 xl:px-4 ${itemClassName}`}
                    {...({} as any)}
                    custom={direction}
                    initial={{ x: `${(currentIndex - 1) * -100}%` }}
                    animate={{ x: `${currentIndex * -100}%` }}
                    variants={variants(200, 1)}
                    style={{ width: `calc(1/${numberOfItems} * 100%)` }}
                  >
                    <CardCategory3
                      taxonomy={{
                        id: item.id,
                        name: item.name,
                        href: `/${item.slug}/khach-san` as Route,
                        taxonomy: "location",
                        count: item.count,
                        thumbnail: item.thumbnail,
                      }}
                    />
                  </motion.li>
                ))}
              </AnimatePresence>
            </motion.ul>
          </div>

          {currentIndex ? (
            <PrevBtn
              style={{ transform: "translate3d(0,0,0)" }}
              onClick={() => changeItemId(currentIndex - 1)}
              className="w-9 h-9 xl:w-12 xl:h-12 text-lg absolute -left-3 xl:-left-6 top-1/3 -translate-y-1/2 z-[1]"
            />
          ) : null}

          {locations.length > currentIndex + numberOfItems && (
            <NextBtn
              style={{ transform: "translate3d(0,0,0)" }}
              onClick={() => changeItemId(currentIndex + 1)}
              className="w-9 h-9 xl:w-12 xl:h-12 text-lg absolute -right-3 xl:-right-6 top-1/3 -translate-y-1/2 z-[1]"
            />
          )}
        </div>
      </MotionConfig>
    </div>
  );
};

export default SectionSliderNewLocations;