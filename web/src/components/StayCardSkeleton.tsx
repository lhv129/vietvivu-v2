"use client";

import React from "react";

const StayCardSkeleton = () => {
    return (
        <div className="animate-pulse rounded-2xl overflow-hidden border border-neutral-200 bg-white">

            {/* Image */}
            <div className="w-full h-52 bg-neutral-200 relative overflow-hidden">
                <div className="absolute inset-0 shimmer"></div>
            </div>

            <div className="p-4 space-y-3">
                {/* Location */}
                <div className="h-3 w-24 bg-neutral-200 rounded"></div>

                {/* Title */}
                <div className="h-4 w-full bg-neutral-200 rounded"></div>
                <div className="h-4 w-2/3 bg-neutral-200 rounded"></div>

                {/* Divider */}
                <div className="border-t border-neutral-100 my-2"></div>

                {/* Rating + price */}
                <div className="flex justify-between items-center">
                    <div className="h-4 w-20 bg-neutral-200 rounded"></div>
                    <div className="h-4 w-16 bg-neutral-200 rounded"></div>
                </div>
            </div>
        </div>
    );
};

export default StayCardSkeleton;