import React from "react";
import logoImg from "@/images/logo-v2.png";
import logoLightImg from "@/images/logo-v2.png";
import Link from "next/link";
import Image, { StaticImageData } from "next/image";

export interface LogoProps {
  img?: StaticImageData;
  imgLight?: StaticImageData;
  className?: string;
}

const Logo: React.FC<LogoProps> = ({
  img = logoImg,
  imgLight = logoLightImg,
  className = "w-12",
}) => {
  return (
    <Link
      href="/"
      className={`ttnc-logo inline-block focus:outline-none focus:ring-0 ${className}`}
    >
      {/* Dark mode */}
      <Image
        src={imgLight}
        alt="Logo"
        className="hidden dark:block"
        priority
      />

      {/* Light mode */}
      <Image
        src={img}
        alt="Logo"
        className="block dark:hidden"
        priority
      />
    </Link>
  );
};

export default Logo;