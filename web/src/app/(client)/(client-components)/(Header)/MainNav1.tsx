import React, { FC } from "react";
import Logo from "@/shared/Logo";
import Navigation from "@/shared/Navigation/Navigation";
import SearchDropdown from "./SearchDropdown";
import ButtonPrimary from "@/shared/ButtonPrimary";
import MenuBar from "@/shared/MenuBar";
import SwitchDarkMode from "@/shared/SwitchDarkMode";

export interface MainNav1Props {
  className?: string;
}

const MainNav1: FC<MainNav1Props> = ({ className = "" }) => {
  return (
    <div className={`nc-MainNav1 relative z-10 ${className}`}>
      <div className="px-4 lg:container h-20 flex items-center justify-between">

        {/* LEFT */}
        <div className="flex items-center space-x-4">
          <Logo className="w-12" />

          {/* DESKTOP NAV */}
          <div className="hidden md:block">
            <Navigation />
          </div>
        </div>

        {/* RIGHT DESKTOP */}
        <div className="hidden md:flex items-center space-x-2 text-neutral-700 dark:text-neutral-100">
          <SwitchDarkMode />
          <SearchDropdown className="flex items-center" />
          <ButtonPrimary href="/login">
            Sign up
          </ButtonPrimary>
        </div>

        {/* MOBILE */}
        <div className="flex md:hidden items-center space-x-2">
          <SwitchDarkMode />
          <MenuBar />
        </div>

      </div>
    </div>
  );
};

export default MainNav1;