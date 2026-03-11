"use client";

import React, { FC, useEffect, useState } from "react";
import { useRouter, useSearchParams } from "next/navigation";
import { StayDataType } from "@/data/types";
import Pagination from "@/shared/Pagination";
import TabFilters from "./TabFilters";
import Heading2 from "@/shared/Heading2";
import StayCard2 from "@/components/StayCard2";
import StayGridSkeleton from "@/components/StayGridSkeleton";

export interface SectionGridFilterCardProps {
  className?: string;
}

const limit = 8;

const SectionGridFilterCard: FC<SectionGridFilterCardProps> = ({
  className = "",
}) => {
  const router = useRouter();
  const searchParams = useSearchParams();

  const [data, setData] = useState<StayDataType[]>([]);
  const [loading, setLoading] = useState(false);
  const [totalPages, setTotalPages] = useState(1);

  const page = Number(searchParams.get("page") || 1);

  const callApi = async () => {
    try {
      setLoading(true);

      const query = searchParams.toString();

      const res = await fetch(`/api/hotels?${query}`);

      const json = await res.json();

      setData(json.data || []);
      setTotalPages(json.totalPages || 1);
    } catch (err) {
      console.error(err);
    } finally {
      setLoading(false);
    }
  };

  useEffect(() => {
    callApi();
  }, [searchParams]);

  const updateUrl = (params: Record<string, any>) => {
    const newParams = new URLSearchParams(searchParams.toString());

    Object.entries(params).forEach(([key, value]) => {
      if (!value || (Array.isArray(value) && value.length === 0)) {
        newParams.delete(key);
      } else {
        if (Array.isArray(value)) {
          newParams.set(key, value.join(","));
        } else {
          newParams.set(key, value.toString());
        }
      }
    });

    router.push(`?${newParams.toString()}`);
  };

  const handleFiltersChange = (filters: any) => {
    updateUrl({
      ...filters,
      page: 1,
    });
  };

  const handlePageChange = (newPage: number) => {
    updateUrl({
      page: newPage,
    });
  };

  return (
    <div
      className={`nc-SectionGridFilterCard ${className}`}
      data-nc-id="SectionGridFilterCard"
    >
      <Heading2 />

      <div className="mb-8 lg:mb-11">
        <TabFilters onChangeFilters={handleFiltersChange} />
      </div>

      {loading ? (
        <StayGridSkeleton />
      ) : (
        <>
          <div className="grid grid-cols-1 gap-6 md:gap-8 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4">
            {data.map((stay) => (
              <StayCard2 key={stay.hotel.id} data={stay} />
            ))}
          </div>

          <div className="flex mt-16 justify-center items-center">
            <Pagination
              currentPage={page}
              totalPages={totalPages}
              onPageChange={handlePageChange}
            />
          </div>
        </>
      )}
    </div>
  );
};

export default SectionGridFilterCard;