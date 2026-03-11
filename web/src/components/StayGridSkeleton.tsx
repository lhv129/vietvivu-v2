"use client";

import React from "react";
import StayCardSkeleton from "./StayCardSkeleton";

const StayGridSkeleton = () => {
    return (
        <div className="grid grid-cols-1 gap-6 md:gap-8 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4">
            {Array.from({ length: 8 }).map((_, index) => (
                <StayCardSkeleton key={index} />
            ))}
        </div>
    );
};

export default StayGridSkeleton;