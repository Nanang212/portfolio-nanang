import { Link } from '@inertiajs/react';
import { useTranslation } from 'react-i18next';
import { Mail, Code2 } from 'lucide-react';
import { GithubIcon, LinkedinIcon } from '@/Components/UI/SocialIcons';

export default function Footer() {
    const { t } = useTranslation();
    const year = new Date().getFullYear();

    return (
        <footer className="border-t border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-900 py-10">
            <div className="container-max px-4 sm:px-6 lg:px-8">
                <div className="flex flex-col md:flex-row items-center justify-between gap-6">
                    {/* Brand */}
                    <div className="flex items-center gap-2 font-bold text-slate-900 dark:text-white">
                        <div className="w-7 h-7 bg-primary-600 rounded-lg flex items-center justify-center">
                            <Code2 size={14} className="text-white" />
                        </div>
                        Nanang<span className="text-primary-600">.</span>
                    </div>

                    {/* Links */}
                    <p className="text-sm text-slate-500 dark:text-slate-400">
                        {t('footer.built_with')} · © {year} {t('footer.rights')}
                    </p>

                    {/* Social */}
                    <div className="flex items-center gap-3">
                        <a href="https://github.com/Nanang212" target="_blank" rel="noopener noreferrer"
                            className="btn-ghost p-2" aria-label="GitHub">
                            <GithubIcon size={18} />
                        </a>
                        <a href="https://www.linkedin.com/in/nanang-aditya/" target="_blank" rel="noopener noreferrer"
                            className="btn-ghost p-2" aria-label="LinkedIn">
                                <LinkedinIcon size={18}/>
                        </a>
                        <a href="mailto:nanangaditya2001@gmail.com"
                            className="btn-ghost p-2" aria-label="Email">
                            <Mail size={18} />
                        </a>
                    </div>
                </div>
            </div>
        </footer>
    );
}
