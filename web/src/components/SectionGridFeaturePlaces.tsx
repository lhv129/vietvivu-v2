"use client";

import React, {
  FC,
  ReactNode,
  useState,
  useMemo,
  useEffect,
} from "react";
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

const INITIAL_ROWS = 3;
const LOAD_MORE_ROWS = 2;

const SectionGridFeaturePlaces: FC<SectionGridFeaturePlacesProps> = ({
  stayListings,
  locations,
  gridClass = "",
  heading = "Khách sạn nổi bật",
  subHeading = "Những nơi lưu trú phổ biến được gợi ý cho bạn",
}) => {
  const [activeLocation, setActiveLocation] = useState<number | null>(
    locations[0]?.id || null
  );

  const [columns, setColumns] = useState(4);
  const [rows, setRows] = useState(INITIAL_ROWS);

  // Detect columns theo screen
  useEffect(() => {
    const updateColumns = () => {
      const width = window.innerWidth;

      if (width < 640) setColumns(1);
      else if (width < 1024) setColumns(2);
      else if (width < 1280) setColumns(3);
      else setColumns(4);
    };

    updateColumns();
    window.addEventListener("resize", updateColumns);

    return () => window.removeEventListener("resize", updateColumns);
  }, []);

  const visibleCount = columns * rows;

  // Filter theo location (DATA MỚI)
  const filteredListings = useMemo(() => {
    if (!activeLocation) return stayListings;

    return stayListings.filter(
      (item) => item?.hotel?.locationId === activeLocation
    );
  }, [stayListings, activeLocation]);

  // Reset rows khi đổi location
  useEffect(() => {
    setRows(INITIAL_ROWS);
  }, [activeLocation]);

  return (
    <div className="nc-SectionGridFeaturePlaces relative">
      <Heading desc={subHeading}>{heading}</Heading>

      {/* Tabs location */}
      <LocationTabs
        locations={locations}
        activeLocation={activeLocation}
        setActiveLocation={setActiveLocation}
      />

      {/* Grid */}
      <div
        className={`grid gap-6 md:gap-8 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 ${gridClass}`}
      >
        {filteredListings.slice(0, visibleCount).map((stay) => (
          <StayCard2 key={stay.hotel.id} data={stay} />
        ))}
      </div>

      {/* Load more */}
      {visibleCount < filteredListings.length && (
        <div className="flex mt-16 justify-center items-center">
          <ButtonPrimary
            onClick={() => setRows((prev) => prev + LOAD_MORE_ROWS)}
          >
            Hiển thị thêm
          </ButtonPrimary>
        </div>
      )}
    </div>
  );
};

export default SectionGridFeaturePlaces;