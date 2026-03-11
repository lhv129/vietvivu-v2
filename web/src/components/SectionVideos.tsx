"use client";

import Heading from "@/shared/Heading";
import NcPlayIcon from "@/shared/NcPlayIcon";
import NcPlayIcon2 from "@/shared/NcPlayIcon2";
import Image from "next/image";
import React, { FC, useState } from "react";

export interface VideoType {
  url: string;
  title: string;
}

export interface SectionVideosProps {
  videos?: VideoType[];
  className?: string;
}

// Demo data (user chỉ cần paste URL youtube)
const VIDEOS_DEMO: VideoType[] = [
  {
    url: "https://www.youtube.com/watch?v=IJQOnYJH-JA",
    title: "Khám phá Hà Nội",
  },
  {
    url: "https://www.youtube.com/watch?v=_CZyMkHXjKQ",
    title: "Khám phá Nha Trang",
  },
  {
    url: "https://www.youtube.com/watch?v=VyIEYVM9eRM",
    title: "Khám phá Đà Lạt",
  },
  {
    url: "https://www.youtube.com/watch?v=RPzJvG9ddfs",
    title: "Khám phá Đà Nẵng",
  },
  {
    url: "https://www.youtube.com/watch?v=6Yx0ttPmWVM",
    title: "TP. Hồ Chí Minh",
  }
];

// Hàm lấy Youtube ID từ URL
const getYoutubeId = (url: string) => {
  const regExp =
    /(?:youtube\.com\/(?:watch\?v=|embed\/)|youtu\.be\/)([^&?/]+)/;
  const match = url.match(regExp);
  return match ? match[1] : "";
};

const SectionVideos: FC<SectionVideosProps> = ({
  videos = VIDEOS_DEMO,
  className = "",
}) => {
  const [isPlay, setIsPlay] = useState(false);
  const [currentVideo, setCurrentVideo] = useState(0);

  const current = videos[currentVideo];
  const videoId = getYoutubeId(current.url);
  const thumbnail = `https://img.youtube.com/vi/${videoId}/maxresdefault.jpg`;

  const renderMainVideo = () => {
    return (
      <div
        className="group aspect-w-16 aspect-h-16 sm:aspect-h-9 bg-neutral-800 rounded-3xl overflow-hidden border-4 border-white dark:border-neutral-900 sm:rounded-[50px] sm:border-[10px]"
        title={current.title}
      >
        {isPlay ? (
          <iframe
            src={`https://www.youtube.com/embed/${videoId}?autoplay=1&loop=1&playlist=${videoId}&rel=0`}
            title={current.title}
            allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
            allowFullScreen
            className="w-full h-full"
          />
        ) : (
          <>
            <div
              onClick={() => setIsPlay(true)}
              className="cursor-pointer absolute inset-0 flex items-center justify-center z-10"
            >
              <NcPlayIcon />
            </div>

            <Image
              fill
              className="object-cover w-full h-full transform transition-transform group-hover:scale-105 duration-300"
              src={thumbnail}
              alt={current.title}
              sizes="(max-width: 1000px) 100vw,
                (max-width: 1200px) 75vw,
                50vw"
            />
          </>
        )}
      </div>
    );
  };

  const renderSubVideo = (video: VideoType, index: number) => {
    if (index === currentVideo) return null;

    const videoId = getYoutubeId(video.url);
    const thumbnail = `https://img.youtube.com/vi/${videoId}/mqdefault.jpg`;

    return (
      <div
        key={index}
        className="group relative aspect-h-16 aspect-w-16 rounded-2xl cursor-pointer overflow-hidden sm:aspect-h-12 sm:rounded-3xl lg:aspect-h-9"
        onClick={() => {
          setCurrentVideo(index);
          setIsPlay(false);
        }}
        title={video.title}
      >
        <div className="absolute inset-0 flex items-center justify-center z-10">
          <NcPlayIcon2 />
        </div>

        <Image
          fill
          className="object-cover w-full h-full transform transition-transform group-hover:scale-110 duration-300"
          src={thumbnail}
          alt={video.title}
          sizes="(max-width: 300px) 100vw,
          (max-width: 1200px) 50vw,
          25vw"
        />
      </div>
    );
  };

  return (
    <div className={`nc-SectionVideos ${className}`}>
      <Heading
        desc="Khám phá những video nổi bật nhất của chúng tôi. Xem thêm và chia sẻ nhiều góc nhìn mới về mọi chủ đề."
      >
        🎬 Video nổi bật
      </Heading>

      <div className="flex flex-col relative sm:pr-4 sm:py-4 md:pr-6 md:py-6 xl:pr-14 xl:py-14 lg:flex-row">
        <div className="absolute -top-4 -bottom-4 -right-4 w-2/3 rounded-3xl bg-primary-100 bg-opacity-40 z-0 sm:rounded-[50px] md:top-0 md:bottom-0 md:right-0 xl:w-1/2 dark:bg-neutral-800 dark:bg-opacity-40"></div>

        <div className="flex-grow relative pb-2 sm:pb-4 lg:pb-0 lg:pr-5 xl:pr-6">
          {renderMainVideo()}
        </div>

        <div className="flex-shrink-0 grid gap-2 grid-cols-4 sm:gap-6 lg:grid-cols-1 lg:w-36 xl:w-40">
          {videos.map(renderSubVideo)}
        </div>
      </div>
    </div>
  );
};

export default SectionVideos;