<?php
  session_start(); // Start a new or resume an existing session
  $pageTitle = 'Eras'; // Set the title of the page
  $pageDesc = 'nfo about the Eras on REVO'; // Set a description for the page
  $isIndex = false; // Flag indicating whether this is the index page
  include './include/globalHeader.php'; // Include the global header bar from the specified file path
?>
        <header>
            <section class="aboutHeader">
                <h1>Eras</h1> <!-- page dedicated to explaining the function of each era tag -->
            </section>
        </header>
        <main>
          <section class="erasInfo"> <!-- basic information on how to use the era tag -->
            <p>REVO utilises era filtering technology that allows users to create posts based around a specific decade that they'd like to reminisce about. All you need to do is click on the buttons at the top of the home page and then you can filter through any era you choose!</p>

            <div>
              <div class="topBanner era1">80s</div>  <!-- info on the 80s tag with basic information about the 80s -->
              <p>Have you ever wanted to look back at iconic 80s moments like neon-lit video game arcades or the blockbuster movie classics such as E.T. the Extra-Terrestrial and Back to the Future? How about those unforgettable TV shows like The A-Team and Miami Vice? REVO is also a place to compare notes on 80s fashion trends like oversized blazers, leg warmers, scrunchies, and (of course) those bold, colorful tracksuits. Now you can easily find 80s posts with REVO’s 80s era tag!</p>
            </div>

            <div>
            <div class="topBanner era2">90s</div> <!-- info on the 90s tag with basic information about the 90s -->
              <p>Remember the golden days of the 90s? A world filled with iconic sitcoms such as Friends and The Fresh Prince of Bel-Air, the dawn of the internet, and those pesky Tamagotchis that were everyone’s pocket pet. This was the decade when boy bands like NSYNC and The Backstreet Boys ruled the charts, and when grunge fashion - think flannel shirts, ripped jeans, and combat boots - defined the cool kids. Whether it was your obsession with Beanie Babies or your love for the groundbreaking Pixar hit Toy Story, there's so much nostalgia to uncover. Find all these 90s vibes with REVO’s 90s era tag!</p>
            </div>

            <div>
              <div class="topBanner era3"><span>00s</span></div> <!-- info on the 2000s tag with basic information about the 2000s -->
              <p>Ah, the 2000s - a time of dial-up internet giving way to broadband, the rise of MySpace, and the reign of early memes like "Dancing Baby." Pop culture thrived with hits like Harry Potter dominating the box office, and Beyoncé rising as a solo superstar. Fashion gave us low-rise jeans, cargo pants, and frosted lip gloss, while technology brought us the iPod and flip phones (remember T9 texting?). Whether you spent your days trying to master the Napoleon Dynamite dance or practicing your best High School Musical sing-alongs, relive the magic of the 2000s with REVO’s 2000s era tag!</p>
            </div>

            <div>
              <div class="topBanner era4">10s</div> <!-- info on the 2010s tag with basic information about the 2010s -->
              <p>The 2010s were a decade of innovation and culture, where smartphones ruled our lives, and social media platforms like Instagram and Vine kept us endlessly connected. Meme culture flourished with Doge (the dog) and the Distracted Boyfriend, while Minecraft YouTubers like Stampy Cat turned gaming into a global phenomenon. Pop icons like  such as Adele and Drake dominated, viral dances like the Harlem Shake swept the world, and Netflix hits like Stranger Things and HBO’s Game of Thrones redefined entertainment. It was a time of creativity, nostalgia, and boundless digital wonder. Relive all the unforgettable moments of the 2010s with the 2010s era tag!</p>
            </div>

            <div>
              <div class="topBanner era5"><span>20s</span></div> <!-- info on the 2020s tag with basic information about the 2020s -->
              <p>Picture a decade defined by TikTok trends, sourdough baking phases, the rise of AI, and heartfelt balcony serenades during pandemic lockdowns. The 2020s brought us unforgettable moments like virtual hangouts becoming the norm and the rise of internet challenges that united the world in laughter. It is a world where both Oppenheimer and Barbie ruled the box office and the amount of streaming services and content has overloaded our senses. Or think about the 2020s fashion trends such as oversized hoodies, chunky sneakers, Y2K-inspired outfits, and, of course, matching loungewear sets born out of quarantine life. Now you can easily dive into 2020s nostalgia with REVO’s 2020s era tag!</p>
            </div>
          </section>
        </main>
<?php
    include './include/globalFooter.php'; // Include the global footer file, which likely contains the footer section of the page
?>