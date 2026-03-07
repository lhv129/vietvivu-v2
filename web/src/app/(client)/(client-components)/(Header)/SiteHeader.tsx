"use client";

import React from "react";
import Header from "./Header";
import { useThemeMode } from "@/utils/useThemeMode";

const SiteHeader = () => {
  useThemeMode();

  return (
    <Header className="shadow-sm dark:border-b dark:border-neutral-700" />
  );
};

export default SiteHeader;