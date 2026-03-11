"use client";

import React, { FC } from "react";
import GallerySlider from "@/components/GallerySlider";
import { DEMO_STAY_LISTINGS } from "@/data/listings";
import { StayDataType } from "@/data/types";
import StartRating from "@/components/StartRating";
import BtnLikeIcon from "@/components/BtnLikeIcon";
import SaleOffBadge from "@/components/SaleOffBadge";
import Link from "next/link";

export interface StayCard2Props {
  className?: string;
  data?: StayDataType;
  size?: "default" | "small";
}

const DEMO_DATA = DEMO_STAY_LISTINGS[0];

const StayCard2: FC<StayCard2Props> = ({
  size = "default",
  className = "",
  data = DEMO_DATA,
}) => {
  const { hotel, pricing, available_rooms } = data;

  const {
    id,
    title,
    address,
    galleryImgs,
    featuredImage,
    slug,
    reviewStart,
    reviewCount,
    location,
  } = hotel;

  const { min_price, original_min_price, discount_percent } = pricing;

  const href = `/${location.slug}/khach-san/${slug}`;

  // IMAGE SLIDER
  const renderSliderGallery = () => {
    return (
      <div className="relative w-full">
        <GallerySlider
          uniqueID={`StayCard2_${id}`}
          ratioClass="aspect-w-12 aspect-h-11"
          galleryImgs={galleryImgs?.length ? galleryImgs : [featuredImage]}
          imageClass="rounded-lg"
          href={href as any}
        />

        <BtnLikeIcon className="absolute right-3 top-3 z-[1]" />

        {discount_percent > 0 && (
          <SaleOffBadge
            className="absolute left-3 top-3"
            text={`-${discount_percent}%`}
          />
        )}
      </div>
    );
  };

  const renderContent = () => {
    return (
      <div className={size === "default" ? "mt-3 space-y-3" : "mt-2 space-y-2"}>
        <div className="space-y-2">
          <span className="text-sm text-neutral-500 dark:text-neutral-400">
            Còn {available_rooms} phòng trống
          </span>

          <h2 className="font-semibold text-base text-neutral-900 dark:text-white">
            <span className="line-clamp-1">{title}</span>
          </h2>

          <div className="flex items-center text-neutral-500 text-sm space-x-1.5">
            <svg
              className="h-4 w-4"
              fill="none"
              viewBox="0 0 24 24"
              stroke="currentColor"
            >
              <path
                strokeLinecap="round"
                strokeLinejoin="round"
                strokeWidth={1.5}
                d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"
              />
              <path
                strokeLinecap="round"
                strokeLinejoin="round"
                strokeWidth={1.5}
                d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"
              />
            </svg>

            <span className="line-clamp-1">{address}</span>
          </div>
        </div>

        <div className="w-14 border-b border-neutral-100 dark:border-neutral-800"></div>

        <div className="flex justify-between items-center">
          <div className="flex flex-col">
            {discount_percent > 0 ? (
              <>
                <span className="line-through text-neutral-400 text-sm">
                  {original_min_price.toLocaleString("vi-VN")}₫
                </span>

                <span className="text-red-500 font-semibold text-base">
                  {min_price.toLocaleString("vi-VN")}₫
                  <span className="text-neutral-500 text-sm ml-1">/đêm</span>
                </span>
              </>
            ) : (
              <span className="font-semibold text-base">
                {min_price.toLocaleString("vi-VN")}₫
                <span className="text-neutral-500 text-sm ml-1">/đêm</span>
              </span>
            )}
          </div>

          {!!reviewStart && (
            <StartRating reviewCount={reviewCount} point={reviewStart} />
          )}
        </div>
      </div>
    );
  };

  return (
    <div className={`nc-StayCard2 group relative ${className}`}>
      {renderSliderGallery()}
      <Link href={href as any}>{renderContent()}</Link>
    </div>
  );
};

export default StayCard2;