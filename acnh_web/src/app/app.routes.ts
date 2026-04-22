import { Routes } from '@angular/router';
import { HomeComponent } from './home/home.component';
import { VillagersComponent } from './villagers/villagers.component';
import { BugsComponent } from './bugs/bugs.component';
import { FishComponent } from './fish/fish.component';
import { SeaCreaturesComponent } from './sea-creatures/sea-creatures.component';

export const routes: Routes = [
    {path: '', redirectTo: 'home', pathMatch: 'full'},
    {path: 'home', component: HomeComponent},
    {path: 'villagers', component: VillagersComponent},
    {path: 'bugs', component: BugsComponent},
    {path: 'fishes', component: FishComponent},
    {path: 'seacreatures', component: SeaCreaturesComponent},

];
