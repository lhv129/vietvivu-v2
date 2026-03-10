import React from "react";
import SectionHero from "./(client)/(client-components)/(HeroSearchForm)/SectionHero";
import SectionSliderNewLocations from "@/components/SectionSliderNewLocations";
import SectionGridFeaturePlaces from "@/components/SectionGridFeaturePlaces";

import { LOCATION_DEMO } from "@/data/locations";
import { DEMO_STAY_LISTINGS } from "@/data/listings";

function PageHome() {
  return (
    <main className="nc-PageHome relative overflow-hidden">
      <div className="container relative space-y-24 mb-24 lg:space-y-28 lg:mb-28">

        <SectionHero className="pt-10 lg:pt-16 lg:pb-16" />

        {/* location slider */}
        <SectionSliderNewLocations locations={LOCATION_DEMO} />

        {/* grid filter */}
        <SectionGridFeaturePlaces
          stayListings={DEMO_STAY_LISTINGS}
          locations={LOCATION_DEMO}
        />

      </div>
    </main>
  );
}

export default PageHome;