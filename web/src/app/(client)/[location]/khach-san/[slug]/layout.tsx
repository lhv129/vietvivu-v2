"use client";

import ListingImageGallery from "@/components/listing-image-gallery/ListingImageGallery";
import { usePathname, useRouter, useSearchParams } from "next/navigation";
import React, { ReactNode } from "react";
import { Route } from "next";
import { imageGallery as listingStayImageGallery } from "./constant";

const DetailLayout = ({ children }: { children: ReactNode }) => {
  const router = useRouter();
  const pathname = usePathname();
  const searchParams = useSearchParams();

  const modal = searchParams?.get("modal");

  const handleCloseModalImageGallery = () => {
    const params = new URLSearchParams(searchParams?.toString());
    params.delete("modal");

    router.push(`${pathname}?${params.toString()}` as Route);
  };

  return (
    <div className="ListingDetailPage">
      <ListingImageGallery
        isShowModal={modal === "PHOTO_TOUR_SCROLLABLE"}
        onClose={handleCloseModalImageGallery}
        images={listingStayImageGallery}
      />

      <div className="container ListingDetailPage__content">
        {children}
      </div>
    </div>
  );
};

export default DetailLayout;