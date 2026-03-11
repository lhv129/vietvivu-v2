"use client";

import React, { FC, ReactNode, useState, useMemo } from "react";
import { StayDataType } from "@/data/types";
import { LocationItem } from "@/data/locations";
import ButtonPrimary from "@/shared/ButtonPrimary";
import StayCard2 from "./StayCard2";
import Heading from "@/shared/Heading";
import LocationTabs from "./LocationsTab";

export interface SectionGridFeaturePlacesProps {
  stayListings: StayDataType[];
  locations: LocationItem[];
  gridClass?: string;
  heading?: ReactNode;
  subHeading?: ReactNode;
}

const INITIAL_ITEMS = 12;
const LOAD_MORE_ITEMS = 8;

const SectionGridFeaturePlaces: FC<SectionGridFeaturePlacesProps> = ({
  stayListings,
  locations,
  gridClass = "",
  heading = "Khách sạn nổi bật",
  subHeading = "Những nơi lưu trú phổ biến được gợi ý cho bạn",
}) => {
  const [activeLocation, setActiveLocation] = useState<number | null>(
    locations?.[0]?.id ?? null
  );

  const [visibleCount, setVisibleCount] = useState(INITIAL_ITEMS);

  // Filter theo location
  const filteredListings = useMemo(() => {
    if (!activeLocation) return stayListings;

    return stayListings.filter(
      (item) => item?.hotel?.location?.id === activeLocation
    );
  }, [stayListings, activeLocation]);

  return (
    <div className="nc-SectionGridFeaturePlaces relative">
      <Heading desc={subHeading}>{heading}</Heading>

      {/* Tabs location */}
      <LocationTabs
        locations={locations}
        activeLocation={activeLocation}
        setActiveLocation={(id) => {
          setActiveLocation(id);
          setVisibleCount(INITIAL_ITEMS);
        }}
      />

      {/* Grid */}
      <div
        className={`grid gap-6 md:gap-8 
        grid-cols-1 
        sm:grid-cols-2 
        lg:grid-cols-3 
        xl:grid-cols-4 
        ${gridClass}`}
      >
        {filteredListings.slice(0, visibleCount).map((stay) => (
          <StayCard2 key={stay.hotel.id} data={stay} />
        ))}
      </div>

      {/* Load more */}
      {visibleCount < filteredListings.length && (
        <div className="flex mt-16 justify-center items-center">
          <ButtonPrimary
            onClick={() =>
              setVisibleCount((prev) => prev + LOAD_MORE_ITEMS)
            }
          >
            Hiển thị thêm
          </ButtonPrimary>
        </div>
      )}
    </div>
  );
};

export default SectionGridFeaturePlaces;