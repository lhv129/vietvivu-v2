import React from "react";
import SectionHero from "./(client)/(client-components)/(HeroSearchForm)/SectionHero";

function PageHome() {
  return (
    <main className="nc-PageHome relative overflow-hidden">
      <div className="container relative space-y-24 mb-24 lg:space-y-28 lg:mb-28">
        {/* SECTION HERO */}
        <SectionHero className="pt-10 lg:pt-16 lg:pb-16" />
      </div>
    </main>
  );
}

export default PageHome;
