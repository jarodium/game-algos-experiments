# game-algos-experiments
Experimenting game related algorimths

## universe folder
- contains tooling for generating a universe, full with galaxies down to planet generation

- Depends on <https://github.com/jarodium/StarGen> to be installed on system.


Todo list for Universe
- [x] Remove Dependency on Zmsg
- [x] Remove Workers for Planet Generation
- [x] Remove Server "Gabriel"
- [ ] Convert StarGen to PHP
- [ ] Planet Generator (planet_gen.php) command line to English
- [x] Remove SQLite Dependency in Planet Generator
- [ ] Planet Topography generated with caracters instead of numbers. ASCII ord according to $e. Saved in .topo ext file
- [ ] Planet Resource generation with caracters instead of numbers. ASCII ord according $m. Saved in .res ext file
- [ ] Planet Biome type generation with caracters instead of numbers. ASCII ord according $m. Saved in .bio ext file
- [ ] Zip it all

Credits:
<https://www.redblobgames.com> for the noise generation tips

<https://github.com/jwagner/simplex-noise.js/blob/master/simplex-noise.js> for the opensimplex class js
