import { NavItemType } from "@/shared/Navigation/NavigationItem";
import ncNanoId from "@/utils/ncNanoId";
import { Route } from "@/routers/types";

export const NAVIGATION_DEMO: NavItemType[] = [
  {
    id: ncNanoId(),
    href: "/" as Route,
    name: "Trang chủ",
  },

  {
    id: ncNanoId(),
    href: "/stays" as Route,
    name: "Khám phá",
    type: "dropdown",
    children: [
      {
        id: ncNanoId(),
        href: "/stays" as Route,
        name: "Khách sạn",
      },
      {
        id: ncNanoId(),
        href: "/stays?type=homestay" as Route,
        name: "Homestay",
      },
      {
        id: ncNanoId(),
        href: "/stays?type=resort" as Route,
        name: "Resort",
      },
      {
        id: ncNanoId(),
        href: "/destinations" as Route,
        name: "Điểm đến nổi bật",
      },
      {
        id: ncNanoId(),
        href: "/deals" as Route,
        name: "Ưu đãi hôm nay",
      },
    ],
  },

  {
    id: ncNanoId(),
    href: "/help-center" as Route,
    name: "Hỗ trợ",
    type: "dropdown",
    children: [
      {
        id: ncNanoId(),
        href: "/help-center" as Route,
        name: "Trung tâm trợ giúp",
      },
      {
        id: ncNanoId(),
        href: "/faq" as Route,
        name: "Câu hỏi thường gặp",
      },
      {
        id: ncNanoId(),
        href: "/contact" as Route,
        name: "Liên hệ hỗ trợ",
      },
      {
        id: ncNanoId(),
        href: "/booking-guide" as Route,
        name: "Hướng dẫn đặt phòng",
      },
      {
        id: ncNanoId(),
        href: "/refund-policy" as Route,
        name: "Chính sách hoàn tiền",
      },
    ],
  },

  {
    id: ncNanoId(),
    href: "/about" as Route,
    name: "Công ty",
    type: "dropdown",
    children: [
      {
        id: ncNanoId(),
        href: "/about" as Route,
        name: "Về chúng tôi",
      },
      {
        id: ncNanoId(),
        href: "/careers" as Route,
        name: "Tuyển dụng",
      },
      {
        id: ncNanoId(),
        href: "/blog" as Route,
        name: "Blog du lịch",
      },
      {
        id: ncNanoId(),
        href: "/partners" as Route,
        name: "Đối tác",
      },
    ],
  },

  {
    id: ncNanoId(),
    href: "/terms" as Route,
    name: "Pháp lý",
    type: "dropdown",
    children: [
      {
        id: ncNanoId(),
        href: "/terms" as Route,
        name: "Điều khoản sử dụng",
      },
      {
        id: ncNanoId(),
        href: "/privacy" as Route,
        name: "Chính sách bảo mật",
      },
      {
        id: ncNanoId(),
        href: "/cookies" as Route,
        name: "Chính sách cookie",
      },
    ],
  }
];
