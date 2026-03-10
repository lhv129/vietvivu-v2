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
  const { hotel, pricing, active_discount } = data;

  const {
    id,
    title,
    address,
    galleryImgs,
    featuredImage,
    slug,
    reviewStart,
    reviewCount,
    empty_room,
  } = hotel;

  const basePrice = pricing.weekday_price;

  const finalPrice = active_discount
    ? active_discount.final_price
    : basePrice;

  const href = `/stays/${slug}`;

  // ===== IMAGE SLIDER =====
  const renderSliderGallery = () => {
    return (
      <div className="relative w-full">
        <GallerySlider
          uniqueID={`StayCard2_${id}`}
          ratioClass="aspect-w-12 aspect-h-11"
          galleryImgs={galleryImgs?.length ? galleryImgs : [featuredImage]}
          imageClass="rounded-lg"
          href={href}
        />

        <BtnLikeIcon className="absolute right-3 top-3 z-[1]" />

        {active_discount && (
          <SaleOffBadge
            className="absolute left-3 top-3"
            text={`-${active_discount.percent}%`}
          />
        )}
      </div>
    );
  };

  // ===== CARD CONTENT =====
  const renderContent = () => {
    return (
      <div className={size === "default" ? "mt-3 space-y-3" : "mt-2 space-y-2"}>
        <div className="space-y-2">
          <span className="text-sm text-neutral-500 dark:text-neutral-400">
            Còn {empty_room} phòng trống
          </span>

          <div className="flex items-center space-x-2">
            <h2
              className={`font-semibold capitalize text-neutral-900 dark:text-white ${size === "default" ? "text-base" : "text-base"
                }`}
            >
              <span className="line-clamp-1">{title}</span>
            </h2>
          </div>

          <div className="flex items-center text-neutral-500 dark:text-neutral-400 text-sm space-x-1.5">
            {size === "default" && (
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
            )}

            <span>{address}</span>
          </div>
        </div>

        <div className="w-14 border-b border-neutral-100 dark:border-neutral-800"></div>

        {/* PRICE */}
        <div className="flex justify-between items-center">
          {/* PRICE */}
          <div className="flex flex-col">
            {active_discount ? (
              <>
                {/* Giá gốc */}
                <span className="line-through text-neutral-400 text-sm">
                  {basePrice.toLocaleString("vi-VN")}₫
                </span>

                {/* Giá giảm */}
                <span className="text-red-500 font-semibold text-base">
                  {finalPrice.toLocaleString("vi-VN")}₫
                  <span className="text-neutral-500 text-sm font-normal ml-1">
                    /đêm
                  </span>
                </span>
              </>
            ) : (
              <span className="font-semibold text-base">
                {basePrice.toLocaleString("vi-VN")}₫
                <span className="text-neutral-500 text-sm font-normal ml-1">
                  /đêm
                </span>
              </span>
            )}
          </div>

          {/* RATING */}
          {!!reviewStart && (
            <div className="flex items-center">
              <StartRating reviewCount={reviewCount} point={reviewStart} />
            </div>
          )}
        </div>
      </div>
    );
  };

  return (
    <div className={`nc-StayCard2 group relative ${className}`}>
      {renderSliderGallery()}
      <Link href={href}>{renderContent()}</Link>
    </div>
  );
};

export default StayCard2;