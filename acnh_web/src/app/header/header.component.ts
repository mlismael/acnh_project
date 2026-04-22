import { Component, inject } from '@angular/core';
import { ThemeService } from '../services/theme.service';
import { RouterLink, RouterLinkActive } from '@angular/router';


@Component({
  selector: 'app-header',
  imports: [
    RouterLink,
    RouterLinkActive],
  templateUrl: './header.component.html',
  styleUrl: './header.component.css',
})
export class HeaderComponent {
  // Inyectamos el servicio
  themeService = inject(ThemeService);

  // Exponemos el signal para que el HTML sea más limpio
  // Al ser un signal, en el HTML lo usaremos como isDark()
  isDark = this.themeService.darkMode;

  toggleTheme() {
    this.themeService.toggleDarkMode();
  }
}
