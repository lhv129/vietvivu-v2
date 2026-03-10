"use client";

import React, { useEffect, useRef, useState } from "react";
import NextBtn from "./NextBtn";
import PrevBtn from "./PrevBtn";

interface Props {
    locations: { id: number; name: string }[];
    activeLocation: number | null;
    setActiveLocation: (id: number) => void;
}

export default function LocationTabs({
    locations,
    activeLocation,
    setActiveLocation,
}: Props) {
    const scrollRef = useRef<HTMLDivElement>(null);

    const [showPrev, setShowPrev] = useState(false);
    const [showNext, setShowNext] = useState(true);

    const checkButtons = () => {
        if (!scrollRef.current) return;

        const { scrollLeft, scrollWidth, clientWidth } = scrollRef.current;

        setShowPrev(scrollLeft > 0);
        setShowNext(scrollLeft + clientWidth < scrollWidth - 5);
    };

    const scroll = (direction: "left" | "right") => {
        if (!scrollRef.current) return;

        const amount = 320;

        scrollRef.current.scrollBy({
            left: direction === "left" ? -amount : amount,
            behavior: "smooth",
        });
    };

    useEffect(() => {
        const el = scrollRef.current;
        if (!el) return;

        checkButtons();
        el.addEventListener("scroll", checkButtons);

        return () => el.removeEventListener("scroll", checkButtons);
    }, []);

    const marginClass =
        showPrev && showNext
            ? "lg:mx-14"
            : showPrev
                ? "lg:ml-14"
                : showNext
                    ? "lg:mr-14"
                    : "";

    return (
        <div className="relative mb-10">
            {showPrev && (
                <div className="hidden lg:block absolute left-0 top-1/2 -translate-y-1/2 z-10">
                    <PrevBtn onClick={() => scroll("left")} />
                </div>
            )}

            <div
                ref={scrollRef}
                className={`flex gap-4 overflow-x-auto whitespace-nowrap scrollbar-hide ${marginClass}`}
                onWheel={(e) => {
                    e.currentTarget.scrollLeft += e.deltaY;
                }}
            >
                {locations.map((loc) => (
                    <button
                        key={loc.id}
                        onClick={() => setActiveLocation(loc.id)}
                        className={`px-4 py-2 rounded-full border flex-shrink-0 transition ${activeLocation === loc.id
                                ? "bg-black text-white"
                                : "bg-white hover:bg-gray-100"
                            }`}
                    >
                        {loc.name}
                    </button>
                ))}
            </div>

            {showNext && (
                <div className="hidden lg:block absolute right-0 top-1/2 -translate-y-1/2 z-10">
                    <NextBtn onClick={() => scroll("right")} />
                </div>
            )}
        </div>
    );
}