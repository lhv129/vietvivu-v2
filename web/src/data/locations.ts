import ncNanoId from "@/utils/ncNanoId";

export interface LocationItem {
  id: string;
  name: string;
}

export const LOCATION_DEMO: LocationItem[] = [
  {
    id: ncNanoId(),
    name: "Hà Nội",
  },
  {
    id: ncNanoId(),
    name: "Nha Trang",
  },
  {
    id: ncNanoId(),
    name: "Đà Nẵng",
  },
  {
    id: ncNanoId(),
    name: "TP. Hồ Chí Minh",
  },
]