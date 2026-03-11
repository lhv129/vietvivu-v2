"use client";

import React, { Fragment, useState, useEffect } from "react";
import { Dialog, Popover, Transition } from "@headlessui/react";
import { useSearchParams } from "next/navigation";
import Checkbox from "@/shared/Checkbox";
import ButtonPrimary from "@/shared/ButtonPrimary";
import ButtonThird from "@/shared/ButtonThird";
import ButtonClose from "@/shared/ButtonClose";
import Slider from "rc-slider";
import convertNumbThousand from "@/utils/convertNumbThousand";

export interface TabFiltersProps {
  onChangeFilters?: (filters: any) => void;
}

const ratings = [1, 2, 3, 4, 5];

const amenities = [
  { id: 1, name: "Bếp" },
  { id: 2, name: "Điều hòa" },
  { id: 3, name: "Sưởi" },
  { id: 4, name: "Máy sấy quần áo" },
  { id: 5, name: "Máy giặt" },
  { id: 6, name: "Wifi" },
  { id: 7, name: "Lò sưởi trong nhà" },
  { id: 8, name: "Bữa sáng" },
  { id: 9, name: "Máy sấy tóc" },
  { id: 10, name: "Bàn làm việc" },
];

const facilities = [
  { id: 1, name: "Chỗ đậu xe miễn phí" },
  { id: 2, name: "Bồn tắm nước nóng" },
  { id: 3, name: "Phòng gym" },
  { id: 4, name: "Hồ bơi" },
  { id: 5, name: "Trạm sạc xe điện" },
];

const propertyTypes = [
  { id: 1, name: "Nhà riêng" },
  { id: 2, name: "Nhà nghỉ B&B" },
  { id: 3, name: "Căn hộ" },
  { id: 4, name: "Khách sạn boutique" },
  { id: 5, name: "Bungalow" },
];

const houseRules = [
  { id: 1, name: "Cho phép thú cưng" },
  { id: 2, name: "Cho phép hút thuốc" },
];

const TabFilters: React.FC<TabFiltersProps> = ({ onChangeFilters }) => {
  const searchParams = useSearchParams();

  const MAX_PRICE = 30000000;
  const DEFAULT_MAX = 0;

  const [rangePrices, setRangePrices] = useState([0, DEFAULT_MAX]);

  const [filters, setFilters] = useState({
    search: "",
    rating: [] as number[],
    minPrice: 0,
    maxPrice: 0,
    amenities: [] as number[],
    facilities: [] as number[],
    propertyTypes: [] as number[],
    houseRules: [] as number[],
    sort: "",
  });

  const [draftFilters, setDraftFilters] = useState(filters);

  const [isOpenMoreFilter, setIsOpenMoreFilter] = useState(false);

  const sorts = [
    { value: "", label: "Đề xuất" },
    { value: "favorite", label: "Yêu thích nhất" },
    { value: "price_desc", label: "Giá cao nhất" },
    { value: "price_asc", label: "Giá thấp nhất" },
  ];

  // ĐỌC FILTER TỪ URL KHI RELOAD
  useEffect(() => {
    const parseArray = (key: string) =>
      searchParams.get(key)?.split(",").map(Number) || [];

    const newFilters = {
      search: searchParams.get("search") || "",
      rating: parseArray("rating"),
      minPrice: Number(searchParams.get("minPrice") || 0),
      maxPrice: Number(searchParams.get("maxPrice") || 0),
      amenities: parseArray("amenities"),
      facilities: parseArray("facilities"),
      propertyTypes: parseArray("propertyTypes"),
      houseRules: parseArray("houseRules"),
      sort: searchParams.get("sort") || "",
    };

    setFilters(newFilters);
    setDraftFilters(newFilters);
    setRangePrices([
      newFilters.minPrice,
      newFilters.maxPrice || MAX_PRICE,
    ]);
  }, [searchParams]);

  const totalMoreFilters =
    filters.amenities.length +
    filters.facilities.length +
    filters.propertyTypes.length +
    filters.houseRules.length;

  const toggleItem = (
    id: number,
    key: "amenities" | "facilities" | "propertyTypes" | "houseRules"
  ) => {
    const list = draftFilters[key];

    const newList = list.includes(id)
      ? list.filter((i) => i !== id)
      : [...list, id];

    setDraftFilters({
      ...draftFilters,
      [key]: newList,
    });
  };

  const toggleRating = (rating: number) => {
    const list = draftFilters.rating;

    const newList = list.includes(rating)
      ? list.filter((r) => r !== rating)
      : [...list, rating];

    setDraftFilters({
      ...draftFilters,
      rating: newList,
    });
  };

  const applyFilters = () => {
    updateFilters(draftFilters);
  };

  const updateFilters = (newFilters: any) => {
    setFilters(newFilters);
    setDraftFilters(newFilters);
    onChangeFilters?.(newFilters);
  };

  const renderXClear = (onClick: () => void) => (
    <span
      onClick={(e) => {
        e.stopPropagation();
        onClick();
      }}
      className="w-4 h-4 rounded-full bg-primary-500 text-white flex items-center justify-center ml-2 cursor-pointer text-xs"
    >
      ✕
    </span>
  );

  // SEARCH
  const renderSearch = () => (
    <div className="flex items-center bg-white rounded-full shadow-sm border border-neutral-200 px-4 py-2 w-[360px] transition hover:shadow-md">
      <input
        value={draftFilters.search}
        onChange={(e) =>
          setDraftFilters({ ...draftFilters, search: e.target.value })
        }
        placeholder="Tìm khách sạn, địa điểm..."
        className="flex-1 bg-transparent border-none outline-none focus:ring-0 text-sm"
      />

      {draftFilters.search && (
        <button
          onClick={() =>
            updateFilters({
              ...filters,
              search: "",
            })
          }
          className="mr-2 text-neutral-400 hover:text-neutral-600"
        >
          ✕
        </button>
      )}

      <button
        onClick={applyFilters}
        className="w-9 h-9 rounded-full bg-primary-600 bg-primary-700 flex items-center justify-center transition"
      >
        <svg
          className="w-4 h-4 text-white"
          fill="none"
          stroke="currentColor"
          strokeWidth="3"
          viewBox="0 0 24 24"
        >
          <path d="M21 21l-4.35-4.35M10 18a8 8 0 100-16 8 8 0 000 16z" />
        </svg>
      </button>
    </div>
  );

  // SORT
  const renderSort = () => {
    const active = filters.sort !== "";

    const current =
      sorts.find((s) => s.value === filters.sort)?.label || "Đề xuất";

    return (
      <Popover className="relative">
        {({ close }) => (
          <>
            <Popover.Button
              className={`flex items-center px-4 py-2 text-sm rounded-full border
            ${active
                  ? "border-primary-500 bg-primary-50 text-primary-700"
                  : "border-neutral-300 hover:border-neutral-400"
                }`}
            >
              <span>{current}</span>

              {active &&
                renderXClear(() => {
                  updateFilters({
                    ...filters,
                    sort: "",
                  });
                })}
            </Popover.Button>

            <Popover.Panel className="absolute z-10 mt-3 w-56 bg-white shadow-xl rounded-2xl p-4 border">
              <div className="space-y-2">
                {sorts.map((item) => (
                  <button
                    key={item.value}
                    onClick={() => {
                      const newFilters = {
                        ...filters,
                        sort: item.value,
                      };

                      setFilters(newFilters);

                      setDraftFilters({
                        ...draftFilters,
                        sort: item.value,
                      });
                      close();
                    }}
                    className={`w-full text-left px-3 py-2 rounded-lg text-sm hover:bg-neutral-100
                    ${filters.sort === item.value
                        ? "bg-neutral-100 font-medium"
                        : ""
                      }`}
                  >
                    {item.label}
                  </button>
                ))}
              </div>
            </Popover.Panel>
          </>
        )}
      </Popover>
    );
  };

  // MORE FILTER
  const renderMoreFilter = () => {
    const renderGroup = (
      title: string,
      list: { id: number; name: string }[],
      key: "amenities" | "facilities" | "propertyTypes" | "houseRules"
    ) => (
      <div className="py-6 border-b">
        <h3 className="font-semibold mb-4">{title}</h3>

        <div className="grid grid-cols-2 gap-3">
          {list.map((item) => (
            <Checkbox
              key={item.id}
              name={item.name}
              label={item.name}
              checked={draftFilters[key].includes(item.id)}
              onChange={() => toggleItem(item.id, key)}
            />
          ))}
        </div>
      </div>
    );

    const active = totalMoreFilters > 0;

    return (
      <>
        <button
          onClick={() => setIsOpenMoreFilter(true)}
          className={`flex items-center px-4 py-2 text-sm rounded-full border
          ${active
              ? "border-primary-500 bg-primary-50 text-primary-700"
              : "border-neutral-300 hover:border-neutral-400"
            }`}
        >
          Tiện ích {active && `(${totalMoreFilters})`}
        </button>

        <Transition appear show={isOpenMoreFilter} as={Fragment}>
          <Dialog
            as="div"
            className="fixed inset-0 z-50"
            onClose={() => setIsOpenMoreFilter(false)}
          >
            <div className="flex items-center justify-center min-h-screen">
              <Dialog.Overlay className="fixed inset-0 bg-black/40" />

              <div className="relative bg-white rounded-2xl shadow-xl w-[750px] max-h-[90vh] overflow-y-auto p-8">
                <div className="flex justify-between items-center mb-6">
                  <h2 className="text-xl font-semibold">Bộ lọc</h2>
                  <ButtonClose onClick={() => setIsOpenMoreFilter(false)} />
                </div>

                {renderGroup("Tiện nghi", amenities, "amenities")}
                {renderGroup("Cơ sở vật chất", facilities, "facilities")}
                {renderGroup("Loại chỗ ở", propertyTypes, "propertyTypes")}
                {renderGroup("Quy tắc nhà", houseRules, "houseRules")}

                <div className="flex justify-between mt-8">
                  <ButtonThird
                    onClick={() =>
                      setDraftFilters({
                        ...draftFilters,
                        amenities: [],
                        facilities: [],
                        propertyTypes: [],
                        houseRules: [],
                      })
                    }
                  >
                    Reset bộ lọc
                  </ButtonThird>

                  <ButtonPrimary
                    onClick={() => {
                      applyFilters();
                      setIsOpenMoreFilter(false);
                    }}
                  >
                    Áp dụng
                  </ButtonPrimary>
                </div>
              </div>
            </div>
          </Dialog>
        </Transition>
      </>
    );
  };

  // PRICE
  const renderPrice = () => {
    const active =
      filters.minPrice !== 0 ||
      filters.maxPrice !== 0;

    return (
      <Popover className="relative">
        {({ close }) => (
          <>
            <Popover.Button
              className={`flex items-center px-3 sm:px-4 py-2 text-xs sm:text-sm rounded-full border
            ${active
                  ? "border-primary-500 bg-primary-50 text-primary-700"
                  : "border-neutral-300 hover:border-neutral-400"
                }`}
            >
              <span>
                {convertNumbThousand(filters.minPrice)}₫ -{" "}
                {convertNumbThousand(filters.maxPrice === 0 ? MAX_PRICE : filters.maxPrice)}₫
              </span>

              {active &&
                renderXClear(() => {
                  const reset = {
                    ...filters,
                    minPrice: 0,
                    maxPrice: 0,
                  };

                  setRangePrices([0, DEFAULT_MAX]);
                  updateFilters(reset);
                })}
            </Popover.Button>

            <Popover.Panel
              className="absolute z-10 mt-3 left-0 right-0 mx-auto md:left-auto md:right-auto w-[50vw] sm:w-[520px] md:w-80 bg-white shadow-xl rounded-2xl p-4 sm:p-5 md:p-6 border"
            >
              {/* SLIDER */}
              <Slider
                range
                min={0}
                max={MAX_PRICE}
                value={[
                  draftFilters.minPrice,
                  draftFilters.maxPrice === 0 ? MAX_PRICE : draftFilters.maxPrice,
                ]}
                allowCross={false}
                onChange={(value) => {
                  const val = value as number[];

                  setRangePrices(val);

                  setDraftFilters({
                    ...draftFilters,
                    minPrice: val[0],
                    maxPrice: val[1],
                  });
                }}
              />

              <div className="flex justify-between mt-4 text-sm">
                <span>{convertNumbThousand(draftFilters.minPrice)}₫</span>
                <span>
                  {convertNumbThousand(
                    draftFilters.maxPrice === 0 ? MAX_PRICE : draftFilters.maxPrice
                  )}
                  ₫
                </span>
              </div>

              {/* INPUT PRICE */}
              <div className="flex flex-col sm:flex-row gap-4 mt-6">
                {/* MIN PRICE */}
                <div className="w-full">
                  <label className="text-xs text-neutral-500">
                    Giá tối thiểu
                  </label>

                  <input
                    type="number"
                    min={0}
                    max={MAX_PRICE}
                    value={draftFilters.minPrice}
                    onChange={(e) => {
                      const val = Math.min(
                        Number(e.target.value),
                        draftFilters.maxPrice
                      );

                      setDraftFilters({
                        ...draftFilters,
                        minPrice: val,
                      });

                      setRangePrices([val, draftFilters.maxPrice]);
                    }}
                    className="w-full border rounded-lg px-3 py-2 text-sm mt-1"
                  />
                </div>

                {/* MAX PRICE */}
                <div className="w-full">
                  <label className="text-xs text-neutral-500">
                    Giá tối đa
                  </label>

                  <input
                    type="number"
                    min={0}
                    max={MAX_PRICE}
                    value={draftFilters.maxPrice === 0 ? MAX_PRICE : draftFilters.maxPrice}
                    onChange={(e) => {
                      const val = Math.max(
                        Number(e.target.value),
                        draftFilters.minPrice
                      );

                      setDraftFilters({
                        ...draftFilters,
                        maxPrice: val,
                      });

                      setRangePrices([draftFilters.minPrice, val]);
                    }}
                    className="w-full border rounded-lg px-3 py-2 text-sm mt-1"
                  />
                </div>
              </div>

              {/* BUTTONS */}
              <div className="flex flex-col sm:flex-row gap-3 sm:gap-0 sm:justify-between mt-6">
                <ButtonThird
                  onClick={() => {
                    setDraftFilters({
                      ...draftFilters,
                      minPrice: 0,
                      maxPrice: 0,
                    });

                    setRangePrices([0, DEFAULT_MAX]);
                  }}
                >
                  Reset
                </ButtonThird>

                <ButtonPrimary
                  onClick={() => {
                    applyFilters();
                    close();
                  }}
                >
                  Áp dụng
                </ButtonPrimary>
              </div>
            </Popover.Panel>
          </>
        )}
      </Popover>
    );
  };

  // RATING
  const renderRating = () => {
    const active = filters.rating.length > 0;

    return (
      <Popover className="relative">
        {({ close }) => (
          <>
            <Popover.Button
              className={`flex items-center px-4 py-2 text-sm rounded-full border
              ${active
                  ? "border-primary-500 bg-primary-50 text-primary-700"
                  : "border-neutral-300 hover:border-neutral-400"
                }`}
            >
              <span>Số sao {active && `(${filters.rating.length})`}</span>

              {active &&
                renderXClear(() => {
                  updateFilters({
                    ...filters,
                    rating: [],
                  });
                })}
            </Popover.Button>

            <Popover.Panel className="absolute z-10 mt-3 w-55 bg-white shadow-xl rounded-2xl p-5 border">
              <div className="space-y-3">
                {ratings.map((r) => (
                  <Checkbox
                    key={r}
                    name={`rating-${r}`}
                    label={"⭐".repeat(r)}
                    checked={draftFilters.rating.includes(r)}
                    onChange={() => toggleRating(r)}
                  />
                ))}
              </div>

              <div className="flex justify-between mt-5">
                <ButtonThird
                  className="!text-xs md:!text-sm !px-3 !py-1"
                  onClick={() =>
                    setDraftFilters({ ...draftFilters, rating: [] })
                  }
                >
                  Reset
                </ButtonThird>

                <ButtonPrimary
                  className="!text-xs md:!text-sm !px-3 !py-1"
                  onClick={() => {
                    applyFilters();
                    close();
                  }}
                >
                  Áp dụng
                </ButtonPrimary>
              </div>
            </Popover.Panel>
          </>
        )}
      </Popover>
    );
  };

  return (
    <div className="flex flex-wrap lg:flex-nowrap justify-start gap-3 items-center relative overflow-visible w-full">
      {renderSearch()}
      {renderSort()}
      {renderMoreFilter()}
      {renderPrice()}
      {renderRating()}
    </div>
  );
};

export default TabFilters;